# مراجعة شاملة لمشروع ONX-EDGE

تاريخ المراجعة: مارس 2026

---

## 1. نظرة عامة على المشروع

- **النوع:** تطبيق ويب Laravel 9 (PHP 8.1+) لإدارة حجوزات فعاليات/إعلانات وواجهة عملاء.
- **التقنيات:** Laravel 9، Vite، Tailwind CSS 4، Laravel Passport، DomPDF، Spatie Media Library، Yajra DataTables، Laravel UI.
- **اللغات:** واجهة عربية مع دعم ترجمة (en/fr) في لوحة التحكم.

### الأقسام الرئيسية
| القسم | المسارات | الوصف |
|-------|----------|--------|
| الواجهة العامة | `/`, `/services`, `/portfolio`, `/contact`, `/faq`, `/booking` | الصفحة الرئيسية، الخدمات، البورتفوليو، تواصل، حجز |
| منطقة العملاء | `/client/*` | تسجيل الدخول (عميل)، لوحة التحكم، حجوزاتي، مدفوعات، ميديا، رسائل، رأي |
| لوحة التحكم | `/admin/*` | حجوزات، تقويم، باقات (أحداث/إعلانات)، بورتفوليو، FAQ، آراء، عملاء، رسائل، موظفون، قاعات أفراح، مستخدمون وصلاحيات، شركة |

---

## 2. نقاط القوة

### 2.1 الأمان
- **منطقة العملاء:** كل إجراء مرتبط بحجز أو ملف يتحقق من `client_id`: `bookingDetail`, `invoicePdf`, `bookingSummary`, `downloadFile`, `downloadSelectedPhotosZip`, `projectPhotosBooking`, `toggleSelectedPhoto`. لا يمكن للعميل الوصول لحجوزات غيره.
- **تحميل الملفات:** `downloadFile` يتحقق من `is_visible` وانتساب الملف لحجز العميل.
- **Throttling:** تحديد معدل الطلبات على تواصل (5/دقيقة)، حجز (10/دقيقة)، دخول العميل (5/دقيقة).
- **معالجة الأخطاء:** معالجة `ThrottleRequestsException` و `PostTooLargeException` برسائل عربية مناسبة في `Handler.php`.
- **حماية CSRF و Session:** مفعّلة ضمن مجموعة middleware الـ web.

### 2.2 البنية والمنطق
- **فصل المنطق:** `BookingService` ي centralize منطق الحجز (إيجاد/إنشاء عميل، إنشاء حجز، حالة التاريخ، `getBookingMeta`).
- **تمييز نوع الباقة:** `getBookingMeta` يربط الباقة بـ `service_type` (event vs ads) ويستخدم الجدول المناسب (EventPackage / AdPackage) مما يمنع عرض باقة خاطئة.
- **تعديل الحجز (Admin):** التحقق من عدم تعارض التاريخ عبر `isDateTakenForUpdate`.
- **تعدد اللغات:** قائمة الأدمن تعتمد `trans('global.menu.*')` مع ملفات `lang/en/global.php` و `lang/fr/global.php`.

### 2.3 تجربة المستخدم
- **SEO:** وجود `robots.txt` و `sitemap.xml` ديناميكيين.
- **توحيد DataTables:** استخدام `datatables_ajax_defaults.blade.php` للعربية وتقليل التكرار.

---

## 3. ملاحظات وتوصيات

### 3.1 تناسق التسمية (تم إصلاحه)
- **تم:** كان الملف `app/Models/Adpackage.php` يحتوي على الكلاس `AdPackage` مما يسبب مشكلة على بيئات Linux (case-sensitive). تم إنشاء `AdPackage.php` وحذف `Adpackage.php` وتوحيد كل المراجع إلى `AdPackage` في `BookingsController` و `ServiceController` و `BookingController`.

### 3.2 مجلدات Views مكررة (تم الحذف)
- **تم:** كان يوجد مجلدان للبورتفوليو (`portfolio-items` و `portfolioItems`). تم حذف مجلد `resources/views/admin/portfolioItems` بالكامل؛ المعتمد الآن هو `admin/portfolio-items` فقط.

### 3.3 مسار التقويم في Admin
- المسار المعرّف: `admin/bookings/calendar` والـ view هي `admin.bookings.calendar`. القائمة والروابط تستخدم ذلك بشكل صحيح. لا التباس مع `admin/calendar` (تم حذف view القديم سابقًا).

### 3.4 حذف جداول الخدمات (Services)
- تم إسقاط جداول `services` و `employee_service` و `appointment_service` عبر migration، وحذف `ServiceResource` و `ServiceFactory` و `ServicesTableSeeder`. قائمة الأدمن لا تحتوي على رابط "الخدمات". الوضع متسق مع قرار إلغاء ميزة إدارة الخدمات من لوحة التحكم.

### 3.5 الاختبارات
- المشروع يحتوي على هيكل الاختبارات الافتراضي (TestCase، ExampleTest في Unit و Feature) دون اختبارات مخصصة للحجز أو منطقة العملاء أو الأدمن.
- **التوصية (اختياري):** إضافة اختبارات أساسية لـ: إنشاء حجز من الواجهة، تسجيل دخول العميل، التحقق من أن العميل لا يصل لحجز غيره (مثلاً `bookingDetail` مع `booking_id` لحجز عميل آخر).

### 3.6 تحسينات اختيارية (من AUDIT_REPORT و CLEANUP_SUMMARY)
- إضافة رابط **الأسئلة الشائعة** في الـ navbar العلوي للواجهة الأمامية (حاليًا في الفوتر فقط).
- إضافة رابط **صفحة الحالة** `/status` في الفوتر أو السايت ماب إذا أردت أن تكون ظاهرة للمستخدمين.

---

## 4. ملخص الحالة

| الجانب | الحالة |
|--------|--------|
| أمان منطقة العملاء (الوصول للحجوزات/الملفات) | ✅ محكم |
| Throttling وحد ال rate | ✅ مطبّق |
| معالجة الأخطاء (throttle, post size) | ✅ موجودة |
| فصل منطق الحجز (BookingService) | ✅ جيد |
| تعدد اللغات في القائمة | ✅ مستخدم |
| SEO (robots, sitemap) | ✅ موجود |
| تناسق اسم نموذج AdPackage/الملف | ✅ تم تصحيحه |
| تنظيف views مكررة (portfolioItems) | ✅ تم حذف المجلد المكرر |
| اختبارات آلية | ⚠️ غير مضافة بعد |

---

## 5. مراجع سابقة

- **AUDIT_REPORT.md** — نقائص سابقة وإصلاحات (PDF الحجز، حذف صفحات يتيمة، توجيه الدخول إلى `/admin`).
- **CLEANUP_SUMMARY.md** — تنفيذ التنظيف (توجيه Auth، DataTables، القائمة، migrations).
- **PROJECT_STRUCTURE.md** — هيكل المجلدات والمسارات.

يمكن الاعتماد على هذا الملف كمرجع لمراجعة المشروع كاملاً وتحديثه لاحقاً.
