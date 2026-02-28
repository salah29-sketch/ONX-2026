@extends('layouts.layout')

@section('styles')
<script>
    window.translations = @json(__('booking'));
</script>
<style>
    /* زر أساسي بلون الموقع */
.btn-primary {
    background-color: #c95518;
    border-color: #c95518;
}

.btn-primary:hover,
.btn-primary:focus {
    background-color: #b44714;
    border-color: #a23f12;
}

/* أزرار outline */
.btn-outline-primary {
    color: #cdcdcd;
    border-color: #c95518;
}

.btn-outline-primary:hover {
    background-color: #c95518;
    color: #fff;
}
.alert.alert-info {
    background-color: transparent !important;
    border: 0px ; /* لون إطار برتقالي مثلاً */
    color: #c95518; /* لون النص */
}
.text-primary {
    color: #c95518 !important;
}
.spinner-border.text-primary {
    color: #c95518;
    border-color: #c95518;
    border-right-color: transparent;
}
.btn-converm {
    background :rgb(224, 70, 23);;
}

    /* ✅ تنسيق الـ Checkbox */
.form-check-input:checked {
    background-color: #c95518;
    border-color: #c95518;
}

.form-check-input:focus {
    border-color: #c95518;
    box-shadow: 0 0 0 0.25rem rgba(201, 85, 24, 0.25);
}
    .container.custom-padding {
  padding-left: 10px;
  padding-right: 10px;
  /* ويمكن تقليل العلوي والسفلي أيضاً إن أردت */
  padding-top: 10px;
  padding-bottom: 10px;
}

.loading-bar {
    color: #c95518;
    font-weight: bold;
    margin-top: 10px;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 4px solid #c95518;
    border-top: 4px solid transparent;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
    margin: 10px auto;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.mt-navbar {
  margin-top: 45px;
}

.card-top {
    border-radius: 12px;
    top: 10px;
}

.is-invalid {
  border-color: #dc3545;
}
.invalid-feedback {
  color: #dc3545;
  font-size: 0.875rem;
}
</style>
 @stop

@section('content')

  <main class="main">
       <!-- Page Title -->
    <div class="page-title" data-aos="fade">

      <nav class="breadcrumbs">
        <div class="container">

        </div>
      </nav>
    </div><!-- End Page Title -->

    <section id="booking" class="portfolio section booking-section mt-navbar"   >

      <!-- Section Title -->
      <div class="container section-title " data-aos="fade-up">
            <h2>{{ __('booking.title') }}</h2>
        <p>{{ __('booking.subtitle') }}</p>
      </div><!-- End Section Title -->

  <div class="container custom-padding">
     <div class="row">
      <div class="col-md-6">

        <div class="app-container " ng-app="dateTimeApp" ng-controller="dateTimeCtrl as ctrl" ng-cloak>

            <div date-picker
                datepicker-title="'{{ __('booking.select_date') }}'"
                picktime="true"
                pickdate="true"
                pickpast="false"
                mondayfirst="false"
                custom-message="ctrl.customMessage"
                selecteddate="ctrl.selected_date"
                updatefn="ctrl.updateDate(newdate)">

		<div class="datepicker am"  >
			<div class="datepicker-header">
				<div class="datepicker-title" ng-if="datepicker_title"> @{{ selectedDay }}  @{{ localdate.getDate() }} @{{ monthNames[localdate.getMonth()] }} </div>
				<div class="datepicker-subheader fw-bold fs-5"
              ng-class="{'text-warning': status === 'booked', 'text-success': status === 'available'}">


        <!-- ✅ عرض رسالة التحقق -->
        @{{ customMessage }}

        <!-- ✅ شريط التحميل أثناء التحقق -->
        <div ng-show="ctrl.loading" class="spinner-border text-primary ms-2" style="width: 1rem; height: 1rem;" role="status">
            <span class="visually-hidden">{{ __('booking.loading') }}</span>
        </div>

        </div>

            </div>
			<div class="datepicker-calendar">
				<div class="calendar-header">
					<div class="goback" ng-click="moveBack()" ng-if="pickdate">
						<svg width="30" height="30">
							<path fill="none" stroke="#0DAD83" stroke-width="3" d="M19,6 l-9,9 l9,9"/>
						</svg>
					</div>
					<div class="current-month-container">@{{ currentViewDate.getFullYear() }} @{{ currentMonthName() }}</div>
					<div class="goforward" ng-click="moveForward()" ng-if="pickdate">
						<svg width="30" height="30">
							<path fill="none" stroke="#0DAD83" stroke-width="3" d="M11,6 l9,9 l-9,9" />
						</svg>
					</div>
				</div>
				<div class="calendar-day-header">
					<span ng-repeat="day in days" class="day-label">@{{ day.short }}</span>
				</div>
				<div class="calendar-grid" ng-class="{false: 'no-hover'}[pickdate]">
					<div
						ng-class="{'no-hover': !day.showday}"
						ng-repeat="day in month"
						class="datecontainer"
						ng-style="{'margin-left': calcOffset(day, $index)}"
						track by $index>
						<div class="datenumber" ng-class="{'day-selected': day.selected }" ng-click="selectDate(day)">
							@{{ day.daydate }}
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
    <div class="buttons-container text-center mt-3"
        ng-if="ctrl.selected_date">
    <button class="btn btn-primary px-4"
            ng-click="ctrl.openForm(ctrl.selected_date)"
            ng-disabled="!ctrl.selected_date || ctrl.status !== 'available'">
         {{ __('booking.next') }}
    </button>
    </div>
    <!-- ✅ Modal لإدخال بيانات الزبون -->
   <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">

   <div class="modal-dialog">
    <div class="modal-content">
      <form (ngSubmit)="onSubmit()"name="form-class" ng-submit="ctrl.submitBooking()" novalidate>

           <div id="selectedDateDisplay" class="alert alert-info text-center fw-bold my-3" style="display: none;" >
            <!-- يتم ملؤه ديناميكيًا -->
            </div>

                    <div class="modal-header">
            <h5 class="modal-title" id="bookingModalLabel">{{ __('booking.client_info') }}</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
        <div class="modal-body">
        <div class="mb-3">
        <label>{{ __('booking.full_name') }}</label>
          <input type="text" ng-model="ctrl.client.name" class="form-control" ng-class="{'is-invalid': ctrl.errors.name}" placeholder="Entrez votre nom complet" />
          <div class="invalid-feedback d-block" ng-if="ctrl.errors.name">@{{ ctrl.errors.name }}</div>
        </div>
        <div class="mb-3">
         <label>{{ __('booking.email') }}</label>
           <input type="email" ng-model="ctrl.client.email" class="form-control" ng-class="{'is-invalid': ctrl.errors.email}" placeholder="example@mail.com" />
           <div class="invalid-feedback d-block" ng-if="ctrl.errors.email">@{{ ctrl.errors.email }}</div>
        </div>
          <div class="mb-3">
             <label>{{ __('booking.phone') }}</label>
            <input type="tel" ng-model="ctrl.client.phone" class="form-control" ng-class="{'is-invalid': ctrl.errors.phone}" placeholder="06 XX XX XX XX" />
            <div class="invalid-feedback d-block" ng-if="ctrl.errors.phone">@{{ ctrl.errors.phone }}</div>
          </div>
               <div class="mb-3">
                 <label>{{ __('booking.choose_location') }}</label>
                    <select name="event_location_id" id="event_location_id" class="form-control"
                                  ng-model="ctrl.client.event_location_id">
                    @foreach($event_locations as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach

                </select>
                <div class="invalid-feedback d-block" ng-if="ctrl.errors.location">@{{ ctrl.errors.location }}</div>
            </div>
                 <div class="mb-3 d-none" id="customLocationWrapper">
                    <label>أدخل مكان الحفل :</label>
                    <input type="text" name="custom_event_location" id="custom_event_location" class="form-control"
                                                         ng-model="ctrl.client.custom_event_location">
                    <div class="invalid-feedback d-block" ng-if="ctrl.errors.locationCustom">@{{ ctrl.errors.locationCustom }}</div>
                </div>

          <div class="mb-3 {{ $errors->has('services') ? 'has-error' : '' }}">
            <label class="d-block mb-2">
                 {{ __('booking.services') }}
            <span class="btn btn-sm btn-outline-primary ms-2 select-all">{{ __('booking.select_all') }}</span>
            <span class="btn btn-sm btn-outline-secondary deselect-all">{{ __('booking.deselect_all') }}</span>
            </label>

            <div class="row">
            @foreach($services as $id => $service)
                <div class="col-md-6">
                    <div class="form-check mb-2">
                        <input type="checkbox"
                            id="service_{{ $id }}"
                            name="services[]"
                            value="{{ $id }}"
                            class="form-check-input service-checkbox"
                            data-price="{{ $service['price'] }}"
                            {{ (in_array($id, old('services', [])) || (isset($appointment) && $appointment->services->contains($id))) ? 'checked' : '' }}>
                        <label for="service_{{ $id }}" class="form-check-label">
                            {{ $service['name'] }}
                        </label>
                    </div>
                    </div>
                @endforeach
            </div>

                @if($errors->has('services'))
                    <em class="invalid-feedback d-block">
                        {{ $errors->first('services') }}
                    </em>
                @endif

                <p class="helper-block">
                   {{ __('booking.services_helper') }}
                </p>
            </div>


        </div>
     <div class="modal-footer flex-column flex-sm-row justify-content-between align-items-stretch gap-2">
    <div class="alert alert-info fw-bold w-100 text-center" id="totalPrice">
        {{ __('booking.total') }}: 0 DA
    </div>
      <button type="submit"
            class="btn btn-success w-100"
            id="confirmBtn"
            ng-disabled="ctrl.submitting">
        <span class="spinner-border spinner-border-sm me-2"
              ng-class="{'d-none': !ctrl.submitting}"
              role="status"
              aria-hidden="true"></span>
        <span>@{{ ctrl.submitting ? 'جاري الإرسال...' : 'Confirmer' }}</span>
    </button>

    <button type="button"
            class="btn btn-secondary w-100"
            data-bs-dismiss="modal"
            ng-click="ctrl.showForm = false">
        {{ __('global.cancel') ?? 'Annuler' }}
    </button>


</div>
      </form>
    </div>
  </div>
</div>



  </div>
</div>

   <!-- ✅ العمود الثاني: ملاحظات الحجز -->
    <div class="col-md-6 mt-6 mt-md-0">

 <div class="card shadow border-0 card-top ">
    <div class="card-body">
        <h4 class="card-title text-primary mb-4"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ __('booking.important_info') }}</h4>
        <ul class="list-unstyled">
        <li class="mb-3">
            <i class="bi bi-cash-coin text-success me-2"></i>
            {!! __('booking.deposit_required') !!}
        </li>
        <li class="mb-3">
            <i class="bi bi-envelope-check text-info me-2"></i>
            {{ __('booking.confirm_after_deposit') }}
        </li>
        <li class="mb-3">
            <i class="bi bi-clock text-warning me-2"></i>
            {{ __('booking.respect_time') }}
        </li>
        <li class="mb-3">
            <i class="bi bi-x-octagon text-danger me-2"></i>
            {{ __('booking.late_cancel') }}
        </li>
        <li class="mb-3">
            <i class="bi bi-camera-reels text-secondary me-2"></i>
            {{ __('booking.photo_usage') }}
        </li>
        <li class="mb-3">
            <i class="bi bi-box-arrow-in-down text-primary me-2"></i>
            {{ __('booking.delivery') }}
        </li>
        <li class="mb-3">
            <i class="bi bi-check-circle text-success me-2"></i>
            {{ __('booking.accept_terms') }}
        </li>
    </ul>
    </div>
</div>

           </div>
        </div>

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->



  </main>



 @endsection

 @section('scripts')

<script>
      function updateTotal() {
        let total = 0;

        document.querySelectorAll('.service-checkbox:checked').forEach(cb => {
            const price = parseFloat(cb.dataset.price || 0);
            total += price;
        });

        document.getElementById('totalPrice').innerText = `Total : ${total.toFixed(2)} DA`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // تحديث المجموع عند تحديد/إلغاء الخدمات يدويًا
        document.querySelectorAll('.service-checkbox').forEach(cb => {
            cb.addEventListener('change', updateTotal);
        });

        // عند الضغط على "Tout sélectionner"
        $('.select-all').click(function () {
            $('.service-checkbox').prop('checked', true);
            updateTotal(); // ✅ تحديث المجموع
        });

        // عند الضغط على "Tout désélectionner"
        $('.deselect-all').click(function () {
            $('.service-checkbox').prop('checked', false);
            updateTotal(); // ✅ تصفير المجموع
        });

        // حساب مبدئي عند تحميل الصفحة
        updateTotal();
    });
    function showBookingModal() {
        var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
        modal.show();
    }

    $(document).ready(function () {
        $('.select-all').click(function () {
            $('.service-checkbox').prop('checked', true);

        });

        $('.deselect-all').click(function () {
            $('.service-checkbox').prop('checked', false);
            zeroTotal();
        });
    });

        $(document).ready(function () {
        $('#event_location_id').on('change', function () {
            if ($(this).val() === 'other') {
                $('#customLocationWrapper').removeClass('d-none');
            } else {
                $('#customLocationWrapper').addClass('d-none');
                $('#custom_event_location').val(''); // تفريغ الحقل إذا لم يكن ظاهراً
            }
        });
    });

</script>
 <script src="{{ asset('js/date-time-picker.js') }}"></script>
 @stop
