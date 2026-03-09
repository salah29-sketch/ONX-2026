document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('bookingFormEl');
  if (!form) return;

  const serviceInput = document.getElementById('service_type');
  const packageTypeInput = document.getElementById('package_type');
  const packageIdInput = document.getElementById('package_id');

  const eventSection = document.getElementById('eventPackagesSection');
  const adsSection = document.getElementById('adsPackagesSection');
  const eventOnlySection = document.getElementById('eventOnlySection');
  const adsOnlySection = document.getElementById('adsOnlySection');
  const calendarCard = document.getElementById('calendarCard');

  const eventDateInput = document.getElementById('event_date');
  const eventDatePreview = document.getElementById('event_date_preview');
  const submitBtn = document.getElementById('submitBtn');
  const submitHelp = document.getElementById('submitHelp');

  const statusBox = document.getElementById('onxStatus');
  const statusText = document.getElementById('onxStatusText');
  const dot = document.getElementById('onxDot');

  const summaryService = document.getElementById('summaryService');
  const summaryPackage = document.getElementById('summaryPackage');
  const summaryDate = document.getElementById('summaryDate');
  const summaryStatus = document.getElementById('summaryStatus');
  const packageContextBadge = document.getElementById('packageContextBadge');

  const locationSelect = document.getElementById('event_location_id');
  const customLocationWrap = document.getElementById('customLocationWrap');

  const serviceCards = document.querySelectorAll('.onx-service-card');
  const packageRadios = document.querySelectorAll('input[name="selected_package"]');

  const monthSelect = document.getElementById('calendarMonthSelect');
  const yearSelect = document.getElementById('calendarYearSelect');

  const bookedDaysUrl = form.dataset.bookedDaysUrl;
  const checkDateUrl = form.dataset.checkDateUrl;

  let confirmedDates = [];
  let pendingDates = [];
  let currentService = 'event';
  let currentDateStatus = 'none';
  let onxFp = null;

  function formatYmdToArabic(ymd) {
    if (!ymd) return '';
    const [y, m, d] = ymd.split('-');
    return `${d}/${m}/${y}`;
  }

  function setStatus(type, text) {
    currentDateStatus = type;
    statusText.textContent = text;

    if (type === 'available') {
      statusBox.style.borderColor = 'rgba(25,135,84,.55)';
      dot.style.background = 'rgba(25,135,84,.92)';
      summaryStatus.innerHTML = '✅ متاح';
    } else if (type === 'pending') {
      statusBox.style.borderColor = 'rgba(245,158,11,.55)';
      dot.style.background = 'rgba(245,158,11,.95)';
      summaryStatus.innerHTML = '🟠 حجز مؤقت';
    } else if (type === 'booked') {
      statusBox.style.borderColor = 'rgba(239,68,68,.55)';
      dot.style.background = 'rgba(239,68,68,.92)';
      summaryStatus.innerHTML = '🔴 محجوز ومؤكد';
    } else {
      statusBox.style.borderColor = 'rgba(255,255,255,.10)';
      dot.style.background = 'rgba(255,255,255,.22)';
      summaryStatus.innerHTML = '<span class="onx-empty">بانتظار الاختيار</span>';
    }

    updateSubmitState();
  }

  function updateSubmitState() {
    const selectedPackage = document.querySelector('input[name="selected_package"]:checked');
    const hasPackage = !!selectedPackage;

    if (currentService === 'event') {
      const hasDate = !!eventDateInput.value;
      submitBtn.disabled = !(hasPackage && hasDate && currentDateStatus === 'available');
      submitHelp.textContent = 'للحفلات: يمكنك اختيار أي تاريخ، لكن لا يمكن الإرسال إلا إذا كان اليوم متاحًا.';
    } else {
      submitBtn.disabled = !hasPackage;
      submitHelp.textContent = 'للإعلانات: اختر الباقة ثم أكمل البيانات ويمكنك الإرسال مباشرة.';
    }
  }

  function updateSummaryPackage() {
    const selected = document.querySelector('input[name="selected_package"]:checked');

    if (!selected) {
      summaryPackage.innerHTML = '<span class="onx-empty">لم يتم الاختيار</span>';
      packageTypeInput.value = '';
      packageIdInput.value = '';
      updateSubmitState();
      return;
    }

    summaryPackage.textContent = selected.dataset.name || 'تم الاختيار';
    packageTypeInput.value = selected.dataset.packageType || '';
    packageIdInput.value = selected.dataset.packageId || '';
    updateSubmitState();
  }

  function clearOtherServicePackages(service) {
    packageRadios.forEach((radio) => {
      if (radio.dataset.service !== service) {
        radio.checked = false;
      }
    });
    updateSummaryPackage();
  }

  function applyServiceMode(type) {
    currentService = type;
    serviceInput.value = type;

    serviceCards.forEach((card) => {
      card.classList.toggle('active', card.dataset.type === type);
    });

    if (type === 'event') {
      eventSection.style.display = '';
      adsSection.style.display = 'none';
      eventOnlySection.style.display = '';
      adsOnlySection.style.display = 'none';
      calendarCard.style.display = '';
      packageContextBadge.textContent = 'باقات الحفلات';
      summaryService.textContent = 'حفلات';

      clearOtherServicePackages('event');

      summaryDate.innerHTML = eventDateInput.value
        ? formatYmdToArabic(eventDateInput.value)
        : '<span class="onx-empty">لم يتم الاختيار</span>';

      if (eventDateInput.value) {
        checkDate(eventDateInput.value);
      } else {
        setStatus('none', 'اختر يومًا');
      }
    } else {
      eventSection.style.display = 'none';
      adsSection.style.display = '';
      eventOnlySection.style.display = 'none';
      adsOnlySection.style.display = '';
      calendarCard.style.display = 'none';

      packageContextBadge.textContent = 'باقات الإعلانات';
      summaryService.textContent = 'إعلانات';

      eventDateInput.value = '';
      eventDatePreview.value = '';
      summaryDate.innerHTML = '<span class="onx-empty">غير مطلوب</span>';
      setStatus('none', 'غير مطلوب للإعلانات');

      clearOtherServicePackages('ads');
      updateSubmitState();
    }
  }

  function attachServiceEvents() {
    serviceCards.forEach((card) => {
      card.addEventListener('click', function () {
        applyServiceMode(this.dataset.type);
      });
    });
  }

  function attachPackageEvents() {
    packageRadios.forEach((radio) => {
      radio.addEventListener('change', function () {
        updateSummaryPackage();
      });
    });
  }

  function attachLocationEvents() {
    if (!locationSelect) return;

    locationSelect.addEventListener('change', function () {
      if (this.value === 'other') {
        customLocationWrap.style.display = 'block';
      } else {
        customLocationWrap.style.display = 'none';
        const customInput = document.getElementById('custom_event_location');
        if (customInput) customInput.value = '';
      }
    });
  }

  function checkDate(date) {
    if (!date || currentService !== 'event') return;

    fetch(`${checkDateUrl}?date=${encodeURIComponent(date)}&service_type=event`)
      .then((r) => r.json())
      .then((data) => {
        if (data.status === 'booked') {
          setStatus('booked', 'هذا اليوم محجوز ومؤكد');
        } else if (data.status === 'pending') {
          setStatus('pending', 'هذا اليوم محجوز مؤقتًا بانتظار العربون');
        } else if (data.status === 'available') {
          setStatus('available', 'هذا اليوم متاح');
        } else {
          setStatus('none', 'اختر يومًا');
        }
      })
      .catch(() => setStatus('none', 'تعذر التحقق من اليوم'));
  }

  function buildCalendar() {
    onxFp = flatpickr('#onxCalendar', {
      inline: true,
      dateFormat: 'Y-m-d',
      minDate: 'today',
      monthSelectorType: 'static',
      locale: {
        firstDayOfWeek: 0
      },

      onDayCreate: function (dObj, dStr, fp, dayElem) {
        const y = dayElem.dateObj.getFullYear();
        const m = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dayElem.dateObj.getDate()).padStart(2, '0');
        const ymd = `${y}-${m}-${d}`;

        if (confirmedDates.includes(ymd)) {
          dayElem.classList.add('onx-booked-day');
          dayElem.setAttribute('title', 'Booked');
        } else if (pendingDates.includes(ymd)) {
          dayElem.classList.add('onx-pending-day');
          dayElem.setAttribute('title', 'Pending');
        }
      },

      onReady: function (selectedDates, dateStr, instance) {
        if (monthSelect) {
          monthSelect.value = String(instance.currentMonth);
          monthSelect.dispatchEvent(new Event('change'));
        }
        if (yearSelect) {
          yearSelect.value = String(instance.currentYear);
          yearSelect.dispatchEvent(new Event('change'));
        }
      },

      onMonthChange: function (selectedDates, dateStr, instance) {
        if (monthSelect) {
          monthSelect.value = String(instance.currentMonth);
          monthSelect.dispatchEvent(new Event('change'));
        }
        if (yearSelect) {
          yearSelect.value = String(instance.currentYear);
          yearSelect.dispatchEvent(new Event('change'));
        }
      },

      onYearChange: function (selectedDates, dateStr, instance) {
        if (monthSelect) {
          monthSelect.value = String(instance.currentMonth);
          monthSelect.dispatchEvent(new Event('change'));
        }
        if (yearSelect) {
          yearSelect.value = String(instance.currentYear);
          yearSelect.dispatchEvent(new Event('change'));
        }
      },

      onChange: function (selectedDates, dateStr) {
        eventDateInput.value = dateStr;
        eventDatePreview.value = formatYmdToArabic(dateStr);
        summaryDate.textContent = formatYmdToArabic(dateStr);
        checkDate(dateStr);
      }
    });

    if (monthSelect) {
      monthSelect.addEventListener('change', function () {
        if (!onxFp) return;
        const selectedMonth = parseInt(this.value, 10);
        const diff = selectedMonth - onxFp.currentMonth;
        if (diff !== 0) onxFp.changeMonth(diff);
      });
    }

    if (yearSelect) {
      yearSelect.addEventListener('change', function () {
        if (!onxFp) return;
        const selectedYear = parseInt(this.value, 10);
        if (selectedYear !== onxFp.currentYear) onxFp.changeYear(selectedYear);
      });
    }
  }

  function initCustomSelects() {
    const customSelects = document.querySelectorAll('.onx-select');

    customSelects.forEach((select) => {
      const realSelectId = select.dataset.select;
      const realSelect = document.getElementById(realSelectId);
      const trigger = select.querySelector('.onx-select-trigger');
      const label = select.querySelector('.onx-select-label');
      const options = select.querySelectorAll('.onx-select-option');

      if (!realSelect || !trigger || !label || !options.length) return;

      function syncFromRealSelect() {
        const currentValue = realSelect.value;
        const matched = Array.from(options).find((opt) => String(opt.dataset.value) === String(currentValue));

        options.forEach((opt) => opt.classList.remove('selected'));

        if (matched) {
          matched.classList.add('selected');
          label.textContent = matched.textContent.trim();
        }
      }

      trigger.addEventListener('click', function () {
        document.querySelectorAll('.onx-select').forEach((other) => {
          if (other !== select) other.classList.remove('open');
        });
        select.classList.toggle('open');
      });

      options.forEach((opt) => {
        opt.addEventListener('click', function () {
          const value = this.dataset.value;
          realSelect.value = value;
          realSelect.dispatchEvent(new Event('change', { bubbles: true }));
          syncFromRealSelect();
          select.classList.remove('open');
        });
      });

      realSelect.addEventListener('change', syncFromRealSelect);
      syncFromRealSelect();
    });

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.onx-select')) {
        document.querySelectorAll('.onx-select').forEach((select) => {
          select.classList.remove('open');
        });
      }
    });
  }

  function loadBookedDays() {
    return fetch(`${bookedDaysUrl}?service_type=event`)
      .then((r) => r.json())
      .then((data) => {
        confirmedDates = Array.isArray(data.confirmed_days) ? data.confirmed_days : [];
        pendingDates = Array.isArray(data.pending_days) ? data.pending_days : [];
      })
      .catch(() => {
        confirmedDates = [];
        pendingDates = [];
      });
  }

  initCustomSelects();
  attachServiceEvents();
  attachPackageEvents();
  attachLocationEvents();

  loadBookedDays().then(() => {
    buildCalendar();
    applyServiceMode('event');
    updateSummaryPackage();
    summaryDate.innerHTML = '<span class="onx-empty">لم يتم الاختيار</span>';
    setStatus('none', 'اختر يومًا');
  });
});