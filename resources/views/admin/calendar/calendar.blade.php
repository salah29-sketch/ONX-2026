@extends('layouts.admin')

@section('content')
<div class="bk-page-head">
    <div>
        <h1 class="bk-title">تقويم مراقبة الحجوزات</h1>
        <div class="bk-subtitle">رؤية أوضح للشهر مع تفاصيل مباشرة لليوم المحدد.</div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="bk-back-btn">
        <i class="fas fa-list"></i>
        الرجوع إلى الحجوزات
    </a>
</div>

<div class="bk-stats">
    <div class="bk-stat-card">
        <div class="bk-stat-label">إجمالي الحجوزات</div>
        <div class="bk-stat-value" id="stat-total">0</div>
    </div>

    <div class="bk-stat-card">
        <div class="bk-stat-label">غير مؤكدة</div>
        <div class="bk-stat-value" id="stat-unconfirmed">0</div>
    </div>

    <div class="bk-stat-card">
        <div class="bk-stat-label">مؤكدة</div>
        <div class="bk-stat-value" id="stat-confirmed">0</div>
    </div>

    <div class="bk-stat-card">
        <div class="bk-stat-label">ملغاة</div>
        <div class="bk-stat-value" id="stat-cancelled">0</div>
    </div>
</div>

<div class="bk-layout">
    <div class="bk-panel">
        <h2 class="bk-panel-title">تقويم الشهر</h2>

        <div class="bk-calendar-wrap">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css"/>
            <div id="calendar"></div>
        </div>
    </div>

    <div class="bk-panel">
        <h2 class="bk-panel-title">تفاصيل اليوم</h2>

        <div class="bk-day-list" id="selected-day-list">
            <div class="bk-empty">
                اختر يومًا من التقويم لعرض الحجوزات الموجودة فيه.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/fr.js"></script>

    <script>
        $(document).ready(function () {
            var rawEvents = {!! json_encode($events) !!} || [];

            function normalizeStatus(status) {
                return status || 'unconfirmed';
            }

            function statusLabel(status) {
                switch (status) {
                    case 'confirmed': return 'مؤكد';
                    case 'in_progress': return 'قيد التنفيذ';
                    case 'completed': return 'مكتمل';
                    case 'cancelled': return 'ملغى';
                    default: return 'غير مؤكد';
                }
            }

            function statusClass(status) {
                switch (status) {
                    case 'confirmed': return 'db-status-confirmed';
                    case 'in_progress': return 'db-status-progress';
                    case 'completed': return 'db-status-completed';
                    case 'cancelled': return 'db-status-cancelled';
                    default: return 'db-status-unconfirmed';
                }
            }

            function renderStats(events) {
                var total = events.length;
                var unconfirmed = 0;
                var confirmed = 0;
                var cancelled = 0;

                events.forEach(function (event) {
                    var status = normalizeStatus(event.status);
                    if (status === 'unconfirmed') unconfirmed++;
                    if (status === 'confirmed') confirmed++;
                    if (status === 'cancelled') cancelled++;
                });

                $('#stat-total').text(total);
                $('#stat-unconfirmed').text(unconfirmed);
                $('#stat-confirmed').text(confirmed);
                $('#stat-cancelled').text(cancelled);
            }

            function renderDayBookings(dateStr) {
                var dayEvents = rawEvents.filter(function (event) {
                    return moment(event.start).format('YYYY-MM-DD') === dateStr;
                });

                if (!dayEvents.length) {
                    $('#selected-day-list').html(
                        '<div class="bk-empty">لا توجد حجوزات في هذا اليوم.</div>'
                    );
                    return;
                }

                var html = '';

                dayEvents.forEach(function (event) {
                    var status = normalizeStatus(event.status);
                    var title = event.title || 'حجز';
                    var url = event.url || '#';
                    var service = event.service_type === 'ads' ? 'إعلانات' : 'حفلات';
                    var location = event.location_name || event.location || '—';

                    html += `
                        <div class="bk-booking-card">
                            <div class="bk-booking-title">${title}</div>
                            <div class="bk-meta">
                                <div><strong>الخدمة:</strong> ${service}</div>
                                <div><strong>المكان:</strong> ${location}</div>
                                <div><strong>الحالة:</strong> ${statusLabel(status)}</div>
                            </div>
                            <a href="${url}" class="bk-view-btn">عرض الحجز</a>
                        </div>
                    `;
                });

                $('#selected-day-list').html(html);
            }

            var styledEvents = rawEvents.map(function (event) {
                event.className = statusClass(normalizeStatus(event.status));
                return event;
            });

            renderStats(rawEvents);

            $('#calendar').fullCalendar({
                locale: 'fr',
                defaultView: 'month',
                events: styledEvents,
                allDayDefault: true,
                height: 'auto',
                fixedWeekCount: false,
                eventLimit: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                dayClick: function (date) {
                    renderDayBookings(moment(date).format('YYYY-MM-DD'));
                },
                eventClick: function (event) {
                    if (event.start) {
                        renderDayBookings(moment(event.start).format('YYYY-MM-DD'));
                    }

                    if (event.url) {
                        window.location.href = event.url;
                        return false;
                    }
                }
            });
        });
    </script>
@stop