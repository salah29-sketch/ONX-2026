document.getElementById("selectedDateDisplay").style.display = 'block';

var app = angular.module('dateTimeApp', []);

app.controller('dateTimeCtrl', function ($scope, $http , $timeout) {
	var ctrl = this;


    ctrl.loading = false;

	ctrl.selected_date = null;

            if (ctrl.selected_date) {
            ctrl.selected_date.setHours(10);
            ctrl.selected_date.setMinutes(0);
        }

    ctrl.customMessage = translations['choose_day'];
    ctrl.buttonMessage = "false";


     ctrl.hasSelectedDate = false;


this.openForm = function (selectedDate) {
    this.selected_date = selectedDate;
    this.client = {}; // إعادة تعيين بيانات العميل

   const display = document.getElementById("selectedDateDisplay");
if (display && selectedDate) {
    const optionsDate = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const dateFormatted = new Date(selectedDate).toLocaleDateString('fr-FR', optionsDate);
    const timeFormatted = "19:00";

    display.innerText = `📅 ${dateFormatted} à ${timeFormatted}`;
    display.style.display = 'block';
}

    // فتح المودال باستخدام Bootstrap 5
    const modal = new bootstrap.Modal(document.getElementById('bookingModal'));
    modal.show();
};

  ctrl.updateDate = function (newdate) {
    if (newdate instanceof Date && !isNaN(newdate.getTime())) {
        newdate.setHours(19);
        newdate.setMinutes(0);

        ctrl.selected_date = newdate;
        ctrl.checkAvailability(newdate);

        ctrl.customMessage = "";
        ctrl.buttonMessage = "false";

        $timeout(() => {
            ctrl.customMessage = translations['check_availability'];
        }, 10);

        window.selectedDate = newdate;

  if (document.getElementById("selectedDateDisplay")) {
    const optionsDate = { day: 'numeric', month: 'long', year: 'numeric' };
    const dateFormatted = newdate.toLocaleDateString('fr-FR', optionsDate); // ➜ 23 juillet 2025
    const timeFormatted = "19:00";

    document.getElementById("selectedDateDisplay").innerText =
        `📅 ${dateFormatted} à ${timeFormatted}`;
}
    }
};

	ctrl.checkAvailability = function (datetime) {

    ctrl.loading = true;


    $http.post('/check-appointment', { datetime: datetime }).then(function (response) {
        if (!response.data.available) {
            ctrl.customMessage = translations["already_booked"];
            ctrl.buttonMessage = "true" ;
            ctrl.status = "booked";
        } else {
            ctrl.customMessage = translations["available"];
            ctrl.buttonMessage = "true" ;
            ctrl.status = "available";
        }
    }).catch(function (error) {
        console.error('❌ Échec de la vérification du rendez-vous :', error);
    }).finally(function () {
        ctrl.loading = false; // إيقاف التحميل بعد انتهاء الطلب
    });
  };


  ctrl.submitBooking = function () {


    ctrl.submitting = true;
    ctrl.errors = {}; // إعادة تعيين الأخطاء

    // التحقق من الحقول
    const name = ctrl.client?.name?.trim();
    const email = ctrl.client?.email?.trim();
    const phone = ctrl.client?.phone?.trim();
    const locationId = ctrl.client?.event_location_id?.trim();
    const customLocation = ctrl.client?.custom_event_location?.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
     const phoneRegex = /^0[5-7][0-9]{8}$/;

   if (!name) {
        ctrl.errors.name = translations["name_required"];
    }
    if (!email || !emailRegex.test(email)) {
        ctrl.errors.email = translations["email_invalid"];
    }
    if (!phone || !phoneRegex.test(phone)) {
        ctrl.errors.phone = translations["phone_invalid"];
    }
    if (!locationId) {
        ctrl.errors.location = translations["location_required"];
    }
    // إن وُجدت أخطاء، نوقف الإرسال
    if (Object.keys(ctrl.errors).length > 0) {
        ctrl.submitting = false;
        return;
    }

    const postData = {
        name: name,
        email: email,
        phone: phone,
        date: ctrl.selected_date,
        services: [],
        event_location_id: locationId,
        custom_event_location: customLocation
    };

    // جمع الخدمات المختارة
    document.querySelectorAll('.service-checkbox:checked').forEach(function (checkbox) {
        postData.services.push(checkbox.value);
    });

    // إرسال البيانات
    fetch('/reservation-api', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(postData)
    })
    .then(response => response.json())
    .then(data => {
        $timeout(() => {

            ctrl.submitting = false;

            if (data.success) {
                Swal.fire({
                        title: translations['success_title'],
                        html: translations['success_msg'],
                        confirmButtonText: translations['confirm']
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                       icon: 'error',
                        title: translations['error_title'],
                        text: data.message || translations['error_msg']
                });
            }
        });
    })
    .catch(err => {
        $timeout(() => {
            ctrl.submitting = false;
            alert("فشل الاتصال بالخادم");
        });
    });
};




  });




 // Date Picker
 app.directive('datePicker', function ($timeout, $window) {
    return {
        restrict: 'AE',
        scope: {
            selecteddate: "=",
            updatefn: "&",
            open: "=",
            datepickerTitle: "@",
            customMessage: "=",
            buttonMessage: "=",
            picktime: "@",
            pickdate: "@",
            pickpast: '=',
			mondayfirst: '@'
        },
		transclude: true,
        link: function (scope, element, attrs, ctrl, transclude) {
			transclude(scope, function(clone, scope) {
				element.append(clone);
			});

            if (!scope.selecteddate) {
                scope.selecteddate = new Date();
            }

            if (attrs.datepickerTitle) {
                scope.datepicker_title = attrs.datepickerTitle;
            }

            scope.days = [
                    { "long":"Dimanche", "short":"Dim" },
                    { "long":"Lundi",    "short":"Lun" },
                    { "long":"Mardi",    "short":"Mar" },
                    { "long":"Mercredi", "short":"Mer" },
                    { "long":"Jeudi",    "short":"Jeu" },
                    { "long":"Vendredi", "short":"Ven" },
                    { "long":"Samedi",   "short":"Sam" },
                ];
			if (scope.mondayfirst == 'true') {
				var sunday = scope.days[0];
				scope.days.shift();
				scope.days.push(sunday);
			}

                scope.monthNames = [
                    "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
                    "Août", "Septembre", "Octobre", "Novembre", "Décembre"
                ];
            function getSelected() {
                if (scope.currentViewDate.getMonth() == scope.localdate.getMonth()) {
                    if (scope.currentViewDate.getFullYear() == scope.localdate.getFullYear()) {
                        for (var number in scope.month) {
                            if (scope.month[number].daydate == scope.localdate.getDate()) {
                                scope.month[number].selected = true;
								if (scope.mondayfirst == 'true') {
									if (parseInt(number) === 0) {
										number = 6;
									} else {
										number = number - 1;
									}
								}
								scope.selectedDay = scope.days[scope.month[number].dayname].long;
							}
                        }
                    }
                }
            }

            function getDaysInMonth() {
                var month = scope.currentViewDate.getMonth();
                var date = new Date(scope.currentViewDate.getFullYear(), month, 1);
                var days = [];
                var today = new Date();
                while (date.getMonth() === month) {
                    var showday = true;
                   // اجعل اليوم الحالي غير متاح
                    var isSameDay = date.getFullYear() === today.getFullYear() &&
                                    date.getMonth() === today.getMonth() &&
                                    date.getDate() === today.getDate();

                    if (!scope.pickpast && (date < today || isSameDay)) {
                        showday = false;
                    }
                    if (today.getDate() == date.getDate() &&
                        today.getYear() == date.getYear() &&
                        today.getMonth() == date.getMonth()) {
                        showday = true;
                    }
                    var day = new Date(date);
                    var dayname = day.getDay();
                    var daydate = day.getDate();
                    days.push({ 'dayname': dayname, 'daydate': daydate, 'showday': showday });
                    date.setDate(date.getDate() + 1);
                }
                scope.month = days;
            }

            function initializeDate() {
                scope.currentViewDate = new Date(scope.localdate);
                scope.currentMonthName = function () {
                    return scope.monthNames[scope.currentViewDate.getMonth()];
                };
                getDaysInMonth();
                getSelected();
            }

            // Takes selected time and date and combines them into a date object
           function getDateAndTime(localdate) {
    var time = scope.time.split(':');
    return new Date(localdate.getFullYear(), localdate.getMonth(), localdate.getDate(), parseInt(time[0]), parseInt(time[1]));
}

            // Convert to UTC to account for different time zones
            function convertToUTC(localdate) {
                var date_obj = getDateAndTime(localdate);
                var utcdate = new Date(date_obj.getUTCFullYear(), date_obj.getUTCMonth(), date_obj.getUTCDate(), date_obj.getUTCHours(), date_obj.getUTCMinutes());
                return utcdate;
            }
            // Convert from UTC to account for different time zones
            function convertFromUTC(utcdate) {
                localdate = new Date(utcdate);
                return localdate;
            }

            // Returns the format of time desired for the scheduler, Also I set the am/pm
            function format24h(date) {
            var hours = date.getHours();
            var minutes = date.getMinutes();
            hours = (hours < 10 ? '0' : '') + hours;
            minutes = (minutes < 10 ? '0' : '') + minutes;
            return hours + ':' + minutes;
        }

            scope.$watch('open', function() {
                if (scope.selecteddate !== undefined && scope.selecteddate !== null) {
                    scope.localdate = convertFromUTC(scope.selecteddate);
                } else {
                    scope.localdate = new Date();
                    scope.localdate.setMinutes(Math.round(scope.localdate.getMinutes() / 60) * 30);
                }

                scope.time = format24h(scope.localdate);
				scope.setTimeBar(scope.localdate);
				initializeDate();
				scope.updateInputTime();
            });

            scope.selectDate = function (day) {

                if (scope.pickdate == "true" && day.showday) {
                    for (var number in scope.month) {
                        var item = scope.month[number];
                        if (item.selected === true) {
                            item.selected = false;
                        }
                    }
                    day.selected = true;
                    scope.selectedDay = scope.days[day.dayname].long;
                    scope.localdate = new Date(scope.currentViewDate.getFullYear(), scope.currentViewDate.getMonth(), day.daydate);
                    initializeDate(scope.localdate);
                    scope.updateDate();
                }
            };

            scope.updateDate = function () {
                if (scope.localdate) {
                    var newdate = getDateAndTime(scope.localdate);
                    scope.updatefn({newdate:newdate});
                }
            };

            scope.moveForward = function () {
                scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() + 1);
                if (scope.currentViewDate.getMonth() == 12) {
                    scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() + 1, 0, 1);
                }
                getDaysInMonth();
                getSelected();
            };

            scope.moveBack = function () {
                scope.currentViewDate.setMonth(scope.currentViewDate.getMonth() - 1);
                if (scope.currentViewDate.getMonth() == -1) {
                    scope.currentViewDate.setDate(scope.currentViewDate.getFullYear() - 1, 0, 1);
                }
                getDaysInMonth();
                getSelected();
            };

            scope.calcOffset = function (day, index) {
                if (index === 0) {
                    var offset = (day.dayname * 14.2857142) + '%';
					if (scope.mondayfirst == 'true') {
						offset = ((day.dayname - 1) * 14.2857142) + '%';
					}
                    return offset;
                }
            };

			///////////////////////////////////////////////
			// Check size of parent element, apply class //
			///////////////////////////////////////////////
			scope.checkWidth = function (apply) {
				var parent_width = element.parent().width();
				if (parent_width < 620) {
					scope.compact = true;
				} else {
					scope.compact = false;
				}
				if (apply) {
					scope.$apply();
				}
			};
			scope.checkWidth(false);

            //////////////////////
            // Time Picker Code //
            //////////////////////
            if (scope.picktime) {
                var currenttime;
                var timeline;
                var timeline_width;
                var timeline_container;
                var sectionlength;

                scope.getHours = function () {
                    var hours = new Array(23);
                    return hours;
                };

                scope.time = "12:00";
                scope.hour = 12;
                scope.minutes = 0;
                scope.currentoffset = 0;

              // scope.timeframe = 'am';

              //  scope.changetime = function(time) {
              //      scope.timeframe = time;
              //      scope.updateDate();
			//		scope.updateInputTime();
             //   };

				scope.edittime = {
					digits: []
				};

				scope.updateInputTime = function () {
    scope.edittime.input = scope.time;
    scope.edittime.formatted = scope.time;
};

				scope.updateInputTime();

				function checkValidTime (number) {
					validity = true;
					switch (scope.edittime.digits.length) {
						case 0:
							if (number === 0) {
								validity = false;
							}
							break;
						case 1:
							if (number > 5) {
								validity = false;
							} else {
								validity = true;
							}
							break;
						case 2:
							validity = true;
							break;
						case 3:
							if (scope.edittime.digits[0] > 1) {
								validity = false;
							} else if (scope.edittime.digits[1] > 2) {
								validity = false;
							} else if (scope.edittime.digits[2] > 5) {
								validity = false;
							}
							else {
								validity = true;
							}
							break;
						case 4:
							validity = false;
							break;
					}
					return validity;
				}

				function formatTime () {
					var time = "";
					if (scope.edittime.digits.length == 1) {
						time = "--:-" + scope.edittime.digits[0];
					} else if (scope.edittime.digits.length == 2) {
						time = "--:" + scope.edittime.digits[0] + scope.edittime.digits[1];
					} else if (scope.edittime.digits.length == 3) {
						time = "-" + scope.edittime.digits[0] + ':' + scope.edittime.digits[1] + scope.edittime.digits[2];
					} else if (scope.edittime.digits.length == 4) {
						time = scope.edittime.digits[0] + scope.edittime.digits[1].toString() + ':' + scope.edittime.digits[2] + scope.edittime.digits[3];
						console.log(time);
					}
					return time ;
				};

				scope.changeInputTime = function (event) {
    if (event.keyCode === 13) { // عند الضغط على Enter
        const input = scope.edittime.input.trim();

        // تحقق من صحة التنسيق HH:MM
        const regex = /^([01]?[0-9]|2[0-3]):([0-5][0-9])$/;
        if (regex.test(input)) {
            // تحديث الوقت في النموذج
            scope.time = input;

            // تحديث التاريخ المحلي بالوقت الجديد
            const [h, m] = input.split(':').map(Number);
            scope.localdate.setHours(h);
            scope.localdate.setMinutes(m);

            // تحديث الوقت الظاهر في التصميم
            scope.edittime.formatted = input;

            // تحديث الشريط الزمني و التحقق من التوفر
            scope.setTimeBar();
            scope.updateDate();
        } else {
            alert("Format de l'heure invalide. Utilisez HH:MM");
        }
    }
};
;

                var pad2 = function (number) {
                    return (number < 10 ? '0' : '') + number;
                };

                scope.moving = false;
                scope.offsetx = 0;
                scope.totaloffset = 0;
                scope.initializeTimepicker = function () {
                    currenttime = $('.current-time');
                    timeline = $('.timeline');
                    if (timeline.length > 0) {
                        timeline_width = timeline[0].offsetWidth;
                    }
                    timeline_container = $('.timeline-container');
                    sectionlength = timeline_width / 24 / 6;
                };

                angular.element($window).on('resize', function () {
                    scope.initializeTimepicker();
                    if (timeline.length > 0) {
                        timeline_width = timeline[0].offsetWidth;
                    }
                    sectionlength = timeline_width / 24;
					scope.checkWidth(true);
                });
scope.setTimeBar = function () {
   return; // Time selection is disabled
};


                scope.getTime = function () {
    // حساب النسبة المئوية للموقع على شريط الزمن
    var percenttime = (scope.currentoffset + 1) / timeline_width;

    // تحويل النسبة إلى دقائق كاملة في اليوم (1440 دقيقة = 24 ساعة)
    var totalMinutes = Math.round(percenttime * 24 * 60);

    // الحد الأقصى هو 23:55 (1435 دقيقة)
    if (totalMinutes >= 1440) {
        totalMinutes = 1439;
    }

    // تحويل الدقائق إلى ساعات ودقائق
    var hour = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;

    // تقريب الدقائق لأقرب 5 دقائق
    minutes = Math.round(minutes / 5) * 5;

    // التأكد ألا تتجاوز 55 دقيقة
    if (minutes === 60) {
        minutes = 55;
    }

    scope.time = pad2(hour) + ":" + pad2(minutes);
    scope.updateInputTime();
    scope.updateDate();
};
                var initialized = false;

                element.on('touchstart', function() {
                    if (!initialized) {
                        element.find('.timeline-container').on('touchstart', function (event) {
                            scope.timeSelectStart(event);
                        });
                        initialized = true;
                    }
                });

                scope.timeSelectStart = function (event) {
                    scope.initializeTimepicker();
                    var timepicker_container = element.find('.timepicker-container-inner');
					var timepicker_offset = timepicker_container.offset().left;
                    if (event.type == 'mousedown') {
                        scope.xinitial = event.clientX;
                    } else if (event.type == 'touchstart') {
                        scope.xinitial = event.originalEvent.touches[0].clientX;
                    }
                    scope.moving = true;
                    scope.currentoffset = scope.xinitial - timepicker_container.offset().left;
                    scope.totaloffset = scope.xinitial - timepicker_container.offset().left;
					console.log(timepicker_container.width());
					if (scope.currentoffset < 0) {
						scope.currentoffset = 0;
					} else if (scope.currentoffset > timepicker_container.width()) {
						scope.currentoffset = timepicker_container.width();
					}
					currenttime.css({
                        transform: 'translateX(' + scope.currentoffset + 'px)',
                        transition: 'none',
                        cursor: 'ew-resize',
                    });
                    scope.getTime();
                };

                angular.element($window).on('mousemove touchmove', function (event) {
                    if (scope.moving === true) {
                        event.preventDefault();
                        if (event.type == 'mousemove') {
                            scope.offsetx = event.clientX - scope.xinitial;
                        } else if (event.type == 'touchmove') {
                            scope.offsetx = event.originalEvent.touches[0].clientX - scope.xinitial;
                        }
                        var movex = scope.offsetx + scope.totaloffset;
                        if (movex >= 0 && movex <= timeline_width) {
                            currenttime.css({
                                transform: 'translateX(' + movex + 'px)',
                            });
                            scope.currentoffset = movex;
                        } else if (movex < 0) {
                            currenttime.css({
                                transform: 'translateX(0)',
                            });
                            scope.currentoffset = 0;
                        } else {
                            currenttime.css({
                                transform: 'translateX(' + timeline_width + 'px)',
                            });
                            scope.currentoffset = timeline_width;
                        }
                        scope.getTime();
                        scope.$apply();
                    }
                });

                angular.element($window).on('mouseup touchend', function (event) {
                    if (scope.moving) {
                        // var roundsection = Math.round(scope.currentoffset / sectionlength);
                        // var newoffset = roundsection * sectionlength;
                        // currenttime.css({
                        //     transition: 'transform 0.25s ease',
                        //     transform: 'translateX(' + (newoffset - 1) + 'px)',
                        //     cursor: 'pointer',
                        // });
                        // scope.currentoffset = newoffset;
                        // scope.totaloffset = scope.currentoffset;
                        // $timeout(function () {
                        //     scope.getTime();
                        // }, 250);
                    }
                    scope.moving = false;
                });

                scope.adjustTime = function (direction) {
                    event.preventDefault();
                    scope.initializeTimepicker();
                    var newoffset;
                    if (direction == 'decrease') {
                        newoffset = scope.currentoffset - sectionlength;
                    } else if (direction == 'increase') {
                        newoffset = scope.currentoffset + sectionlength;
                    }
                    if (newoffset < 0 || newoffset > timeline_width) {
                        if (newoffset < 0) {
                            newoffset = timeline_width - sectionlength;
                        } else if (newoffset > timeline_width) {
                            newoffset = 0 + sectionlength;
                        }

                    }
                    currenttime.css({
                        transition: 'transform 0.4s ease',
                        transform: 'translateX(' + (newoffset - 1) + 'px)',
                    });
                    scope.currentoffset = newoffset;
                    scope.totaloffset = scope.currentoffset;
                    scope.getTime();
                };
            }


        }
    };
});
