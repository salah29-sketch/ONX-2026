document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('bookingFormEl');
  if (!form) return;

  const serviceInput      = document.getElementById('service_type');
  const packageTypeInput  = document.getElementById('package_type');
  const packageIdInput    = document.getElementById('package_id');

  const eventSection      = document.getElementById('eventPackagesSection');
  const adsSection        = document.getElementById('adsPackagesSection');
  const eventOnlySection  = document.getElementById('eventOnlySection');
  const adsOnlySection    = document.getElementById('adsOnlySection');
  const calendarCard      = document.getElementById('calendarCard');
  const bookingCard       = document.getElementById('bookingCard');

  const eventDateInput    = document.getElementById('event_date');
  const eventDatePreview  = document.getElementById('event_date_preview');
  const submitBtn         = document.getElementById('submitBtn');
  const submitHelp        = document.getElementById('submitHelp');

  const statusBox   = document.getElementById('onxStatus');
  const statusText  = document.getElementById('onxStatusText');
  const dot         = document.getElementById('onxDot');

  const summaryService      = document.getElementById('summaryService');
  const summaryPackage      = document.getElementById('summaryPackage');
  const summaryDate         = document.getElementById('summaryDate');
  const summaryStatus       = document.getElementById('summaryStatus');
  const summaryLocation     = document.getElementById('summaryLocation');
  const summaryDeadline     = document.getElementById('summaryDeadline');
  const summaryDateRow      = document.getElementById('summaryDateRow');
  const summaryLocationRow  = document.getElementById('summaryLocationRow');
  const summaryDeadlineRow  = document.getElementById('summaryDeadlineRow');
  const packageContextBadge = document.getElementById('packageContextBadge');

  const locationSelect      = document.getElementById('event_location_id');
  const customLocationWrap  = document.getElementById('customLocationWrap');
  const customLocationInput = document.getElementById('custom_event_location');
  const deadlineInput       = document.getElementById('deadline');

  const serviceCards  = document.querySelectorAll('.onx-service-card');
  const packageRadios = document.querySelectorAll('input[name="selected_package"]');
  const monthSelect   = document.getElementById('calendarMonthSelect');
  const yearSelect    = document.getElementById('calendarYearSelect');

  const bookedDaysUrl = form.dataset.bookedDaysUrl;
  const checkDateUrl  = form.dataset.checkDateUrl;

  let confirmedDates    = [];
  let pendingDates      = [];
  let currentService    = serviceInput?.value || 'event';
  let currentDateStatus = 'none';
  let onxFp             = null;

  /* ── helpers ───────────────────────────────────────────────── */
  function fmt(ymd) {
    if (!ymd) return '';
    const [y, m, d] = ymd.split('-');
    return `${d}/${m}/${y}`;
  }

  function empty(text) {
    return `<span style="color:rgba(255,255,255,.35)">${text}</span>`;
  }

  function getCheckedPackage(service) {
    const sel = document.querySelector('input[name="selected_package"]:checked');
    if (!sel) return null;
    if (service && sel.dataset.service !== service) return null;
    return sel;
  }

  /* ── status ────────────────────────────────────────────────── */
  function setStatus(type, text) {
    currentDateStatus = type;
    if (statusText) statusText.textContent = text;
    if (statusBox) {
      statusBox.classList.remove('onx-status-success', 'onx-status-warning', 'onx-status-danger');
      statusBox.style.borderColor = 'rgba(255,255,255,.10)';
    }
    if (dot) dot.style.background = 'rgba(255,255,255,.22)';

    if (type === 'available') {
      statusBox && statusBox.classList.add('onx-status-success');
      if (dot) dot.style.background = 'rgba(34,197,94,.92)';
      if (summaryStatus) summaryStatus.innerHTML = '<span style="color:#4ade80">✅ متاح</span>';
    } else if (type === 'pending') {
      statusBox && statusBox.classList.add('onx-status-warning');
      if (dot) dot.style.background = 'rgba(245,158,11,.95)';
      if (summaryStatus) summaryStatus.innerHTML = '<span style="color:#fb923c">🟠 حجز مؤقت</span>';
    } else if (type === 'booked') {
      statusBox && statusBox.classList.add('onx-status-danger');
      if (dot) dot.style.background = 'rgba(239,68,68,.92)';
      if (summaryStatus) summaryStatus.innerHTML = '<span style="color:#f87171">🔴 محجوز ومؤكد</span>';
    } else {
      if (summaryStatus) summaryStatus.innerHTML = empty('بانتظار الاختيار');
    }

    updateSubmitState();
  }

  /* ── submit state ──────────────────────────────────────────── */
  function updateSubmitState() {
    const hasPkg = !!getCheckedPackage(currentService);
    const hasDate = !!eventDateInput.value;
    if (currentService === 'event') {
      submitBtn.disabled = !(hasPkg && hasDate && currentDateStatus === 'available');
      submitHelp.textContent = !hasPkg
        ? 'اختر الباقة أولًا للمتابعة.'
        : !hasDate
          ? 'اختر يومًا من التقويم لإكمال الحجز.'
          : currentDateStatus !== 'available'
            ? 'اليوم المحدد غير متاح. اختر يومًا آخر.'
            : 'البيانات مكتملة. يمكنك الآن إرسال طلب الحجز.';
    } else {
      submitBtn.disabled = !(hasPkg && hasDate);
      submitHelp.textContent = !hasPkg
        ? 'اختر الباقة أولًا للمتابعة.'
        : !hasDate
          ? 'اختر يومًا من التقويم (مطلوب للإعلانات أيضًا).'
          : 'البيانات جاهزة. يمكنك الآن إرسال طلب الإعلان.';
    }
  }

  /* ── summary ───────────────────────────────────────────────── */
  function updateSummaryPackage() {
    const sel = getCheckedPackage(currentService);
    const adsTypeInput = document.getElementById('ads_type');
    const budgetWrap   = document.getElementById('budgetFieldWrap');
    const budgetInput  = document.getElementById('budget_input');
    if (!sel) {
      if (summaryPackage) summaryPackage.innerHTML = empty('لم يتم الاختيار');
      packageTypeInput.value = ''; packageIdInput.value = '';
      if (adsTypeInput) adsTypeInput.value = '';
      if (budgetWrap) budgetWrap.style.display = '';
    } else {
      if (summaryPackage) summaryPackage.textContent = sel.dataset.name || 'تم الاختيار';
      packageTypeInput.value = sel.dataset.packageType || '';
      packageIdInput.value   = sel.dataset.packageId   || '';
      if (adsTypeInput) adsTypeInput.value = sel.dataset.adsType || '';
      // إخفاء حقل الميزانية للباقات الشهرية (السعر من الباقة)
      const isMonthly = sel.dataset.adsType === 'monthly';
      if (budgetWrap) budgetWrap.style.display = isMonthly ? 'none' : '';
      if (budgetInput && isMonthly) budgetInput.value = '';
    }
    updateSubmitState();
  }

  function updateSummaryLocation() {
    if (!summaryLocation) return;
    if (currentService !== 'event' || !locationSelect?.value)
      return void (summaryLocation.innerHTML = empty(currentService !== 'event' ? 'غير مطلوب' : 'غير محدد'));
    summaryLocation.textContent = locationSelect.value === 'other'
      ? (customLocationInput?.value?.trim() || 'مكان آخر')
      : (locationSelect.selectedOptions?.[0]?.textContent?.trim() || 'غير محدد');
  }

  function updateSummaryDeadline() {
    if (!summaryDeadline) return;
    summaryDeadline.innerHTML = deadlineInput?.value ? deadlineInput.value : empty('غير محدد');
  }

  function clearOtherServicePackages(service) {
    packageRadios.forEach(r => { if (r.dataset.service !== service) r.checked = false; });
    updateSummaryPackage();
  }

  /* ── service mode ──────────────────────────────────────────── */
  function applyServiceMode(type) {
    currentService = type; serviceInput.value = type;
    serviceCards.forEach(c => c.classList.toggle('active', c.dataset.type === type));
    if (bookingCard) bookingCard.classList.toggle('mode-ads', type === 'ads');

    if (type === 'event') {
      eventSection.style.display     = ''; adsSection.style.display       = 'none';
      eventOnlySection.style.display = ''; adsOnlySection.style.display   = 'none';
      calendarCard.style.display     = '';
      packageContextBadge.textContent = 'باقات الحفلات';
      summaryService.textContent      = 'حفلات';
      if (summaryDateRow)     summaryDateRow.style.display     = '';
      if (summaryLocationRow) summaryLocationRow.style.display = '';
      if (summaryDeadlineRow) summaryDeadlineRow.style.display = 'none';
      clearOtherServicePackages('event');
      summaryDate.innerHTML = eventDateInput.value ? fmt(eventDateInput.value) : empty('لم يتم الاختيار');
      updateSummaryLocation();
      eventDateInput.value ? checkDate(eventDateInput.value) : setStatus('none', 'اختر يومًا');
    } else {
      eventSection.style.display     = 'none'; adsSection.style.display       = '';
      eventOnlySection.style.display = 'none'; adsOnlySection.style.display   = '';
      calendarCard.style.display     = '';
      packageContextBadge.textContent = 'باقات الإعلانات';
      summaryService.textContent      = 'إعلانات';
      eventDateInput.value = ''; if (eventDatePreview) eventDatePreview.value = '';
      currentDateStatus = 'none';
      if (onxFp) onxFp.clear();
      if (summaryDateRow)     summaryDateRow.style.display     = '';
      if (summaryLocationRow) summaryLocationRow.style.display = 'none';
      if (summaryDeadlineRow) summaryDeadlineRow.style.display = '';
      summaryDate.innerHTML = empty('لم يتم الاختيار');
      updateSummaryDeadline();
      setStatus('none', 'اختر يومًا من التقويم');
      clearOtherServicePackages('ads');
    }
    updateSummaryPackage(); updateSubmitState();
  }

  /* ── check date ────────────────────────────────────────────── */
  function checkDate(date) {
    if (!date) return;
    if (currentService === 'ads') {
      setStatus('available', 'تم اختيار اليوم');
      if (summaryStatus) summaryStatus.innerHTML = '<span style="color:#4ade80">تم اختيار اليوم</span>';
      updateSubmitState();
      return;
    }
    fetch(`${checkDateUrl}?date=${encodeURIComponent(date)}&service_type=event`)
      .then(r => r.json())
      .then(data => {
        if      (data.status === 'booked')    setStatus('booked',    'هذا اليوم محجوز ومؤكد');
        else if (data.status === 'pending')   setStatus('pending',   'هذا اليوم محجوز مؤقتًا');
        else if (data.status === 'available') setStatus('available', 'هذا اليوم متاح');
        else                                  setStatus('none',      'اختر يومًا');
      })
      .catch(() => setStatus('none', 'تعذر التحقق من اليوم'));
  }

  /* ── calendar ──────────────────────────────────────────────── */
  function buildCalendar() {
    onxFp = flatpickr('#onxCalendar', {
      inline: true,
      dateFormat: 'Y-m-d',
      minDate: 'today',
      monthSelectorType: 'static',
      locale: { firstDayOfWeek: 0 },

      onDayCreate(selectedDates, dateStr, instance, dayElem) {
        dayElem.classList.remove('today');
      },

      onReady(selectedDates, dateStr, instance) {
        syncCalendarSelects(instance);
      },

      onMonthChange(selectedDates, dateStr, instance) {
        syncCalendarSelects(instance);
      },

      onYearChange(selectedDates, dateStr, instance) {
        syncCalendarSelects(instance);
      },

      onChange(selectedDates, dateStr) {
        eventDateInput.value = dateStr;
        if (eventDatePreview) eventDatePreview.value = fmt(dateStr);
        if (summaryDate) summaryDate.textContent = fmt(dateStr);
        checkDate(dateStr);
      }
    });

    if (monthSelect) monthSelect.addEventListener('change', function () {
      if (!onxFp) return;
      const targetMonth = parseInt(this.value, 10);
      if (targetMonth === onxFp.currentMonth) return;
      onxFp.changeMonth(targetMonth, false);
    });
    if (yearSelect) yearSelect.addEventListener('change', function () {
      if (!onxFp) return;
      const y = parseInt(this.value, 10);
      if (y === onxFp.currentYear) return;
      onxFp.changeYear(y);
    });
  }

  function syncCalendarSelects(inst) {
    if (monthSelect) { monthSelect.value = String(inst.currentMonth); syncLabel('calendarMonthSelect'); }
    if (yearSelect)  { yearSelect.value  = String(inst.currentYear);  syncLabel('calendarYearSelect'); }
  }

  /* ── custom selects ────────────────────────────────────────── */
  function syncLabel(id) {
    const real = document.getElementById(id);
    const wrap = document.querySelector(`.onx-select[data-select="${id}"]`);
    if (!real || !wrap) return;
    const lbl = wrap.querySelector('.onx-select-label');
    const opts = wrap.querySelectorAll('.onx-select-option');
    if (!lbl) return;
    let found = false;
    opts.forEach(o => {
      const a = String(o.dataset.value) === String(real.value);
      o.classList.toggle('selected', a);
      if (a) { lbl.textContent = o.textContent.trim(); found = true; }
    });
    if (!found && real.selectedOptions?.[0]) lbl.textContent = real.selectedOptions[0].textContent.trim();
  }

  function initCustomSelects() {
    document.querySelectorAll('.onx-select').forEach(wrap => {
      const real = document.getElementById(wrap.dataset.select);
      const trig = wrap.querySelector('.onx-select-trigger');
      const lbl  = wrap.querySelector('.onx-select-label');
      const opts = wrap.querySelectorAll('.onx-select-option');
      if (!real || !trig || !lbl || !opts.length) return;

      function sync() {
        const v = real.value; let found = false;
        opts.forEach(o => {
          const a = String(o.dataset.value) === String(v);
          o.classList.toggle('selected', a);
          if (a) { lbl.textContent = o.textContent.trim(); found = true; }
        });
        if (!found && real.selectedOptions?.[0]) lbl.textContent = real.selectedOptions[0].textContent.trim();
      }
      trig.addEventListener('click', () => {
        document.querySelectorAll('.onx-select').forEach(o => o !== wrap && o.classList.remove('open'));
        wrap.classList.toggle('open');
      });
      opts.forEach(o => o.addEventListener('click', function () {
        real.value = this.dataset.value;
        real.dispatchEvent(new Event('change', { bubbles: true }));
        sync(); wrap.classList.remove('open');
      }));
      real.addEventListener('change', sync);
      sync();
    });
    document.addEventListener('click', e => {
      if (!e.target.closest('.onx-select'))
        document.querySelectorAll('.onx-select').forEach(s => s.classList.remove('open'));
    });
  }

  /* ── location & deadline ───────────────────────────────────── */
  function attachLocationEvents() {
    if (!locationSelect) return;
    const sync = () => {
      if (customLocationWrap) customLocationWrap.style.display = locationSelect.value === 'other' ? '' : 'none';
      if (locationSelect.value !== 'other' && customLocationInput) customLocationInput.value = '';
      updateSummaryLocation();
    };
    locationSelect.addEventListener('change', sync);
    if (customLocationInput) customLocationInput.addEventListener('input', updateSummaryLocation);
    sync();
  }

  function attachDeadlineEvents() {
    if (!deadlineInput) return;
    ['input','change'].forEach(ev => deadlineInput.addEventListener(ev, updateSummaryDeadline));
  }

  /* ── booked days ───────────────────────────────────────────── */
  function loadBookedDays() {
    return fetch(`${bookedDaysUrl}?service_type=event`)
      .then(r => r.json())
      .then(d => {
        confirmedDates = Array.isArray(d.confirmed_days) ? d.confirmed_days : [];
        pendingDates   = Array.isArray(d.pending_days)   ? d.pending_days   : [];
      })
      .catch(() => { confirmedDates = []; pendingDates = []; });
  }

  /* ── auto-select من URL params ─────────────────────────────── */
  function applyUrlParams() {
    const params      = new URLSearchParams(window.location.search);
    const packageId   = params.get('package_id');
    const serviceType = params.get('type'); // 'event' أو 'ads'

    if (!packageId) return;

    // 1. تبديل نوع الخدمة إذا لزم
    if (serviceType && serviceType !== currentService) {
      applyServiceMode(serviceType);
    }

    // 2. إيجاد الـ radio وتحديده
    const prefix     = (serviceType === 'ads') ? 'ad' : 'event';
    const radioValue = `${prefix}:${packageId}`;
    const radio      = document.querySelector(
      `input[type="radio"][name="selected_package"][value="${radioValue}"]`
    );

    if (!radio) return;

    radio.checked = true;
    radio.dispatchEvent(new Event('change', { bubbles: true }));

    // 3. scroll ناعم إلى الباقة
    const box = radio.nextElementSibling; // .package-box
    if (box) {
      box.scrollIntoView({ behavior: 'smooth', block: 'center' });

      // وميض برتقالي لمدة 1.8 ثانية
      box.style.transition = 'box-shadow 0.3s ease';
      box.style.boxShadow  = '0 0 0 3px rgba(249,115,22,0.60)';
      setTimeout(() => { box.style.boxShadow = ''; }, 1800);
    }
  }

  /* ── init ──────────────────────────────────────────────────── */
  initCustomSelects();
  attachLocationEvents();
  attachDeadlineEvents();
  serviceCards.forEach(c => c.addEventListener('click', function () { applyServiceMode(this.dataset.type); }));
  packageRadios.forEach(r => r.addEventListener('change', updateSummaryPackage));

  loadBookedDays().then(() => {
    buildCalendar();
    applyServiceMode(currentService);
    updateSummaryPackage();
    updateSummaryLocation();
    updateSummaryDeadline();
    if (currentService === 'event') {
      if (eventDateInput.value) {
        summaryDate.textContent = fmt(eventDateInput.value);
        checkDate(eventDateInput.value);
      } else {
        summaryDate.innerHTML = empty('لم يتم الاختيار');
        setStatus('none', 'اختر يومًا');
      }
    } else {
      summaryDate.innerHTML = empty('لم يتم الاختيار');
      setStatus('none', 'اختر يومًا من التقويم');
    }
    updateSubmitState();

    // ── تطبيق URL params بعد اكتمال كل شيء ──
    applyUrlParams();
  });
});