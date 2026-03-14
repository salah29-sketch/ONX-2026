# ملخص مراجعة وتنظيف المشروع — ONX-EDGE

تاريخ: 2025

---

## ما تم تنفيذه

### 1. إصلاح توجيه الدخول (Auth)
- **المشكلة:** بعد تسجيل الدخول كان التوجيه إلى `/home` ولا يوجد route بهذا المسار → احتمال 404.
- **الإجراء:** تغيير `$redirectTo` من `'/home'` إلى `'/admin'` في:
  - `LoginController`
  - `RegisterController`
  - `ResetPasswordController`
  - `VerificationController`

### 2. إزالة الصفحات والملفات اليتيمة
- **حذف** `resources/views/client/photos.blade.php`: صفحة بدون route ولا `client.photos.store`.
- **حذف** `resources/views/admin/calendar/calendar.blade.php`: تقويم مكرر غير مستخدم (المستخدم هو `admin/bookings/calendar.blade.php`).
- **توثيق** `admin/services/`: إضافة `resources/views/admin/services/README.md` لشرح تفعيل إدارة الخدمات لاحقاً (routes + ServiceController + رابط القائمة).

### 3. تنظيف الكود
- **قائمة العميل:** إزالة الشرط `!request()->routeIs('client.photos*')` من `client/layout.blade.php` لأن route `client.photos` غير معرّف.
- **Migration:** تصحيح اسم الكلاس من `AddDeletedAtToeventlocationsTable` إلى `AddDeletedAtToEventLocationsTable` في migration الـ `deleted_at` لجدول `event_locations`.

### 4. تقليل التكرار (DataTables)
- **إضافة** `resources/views/partials/datatables_ajax_defaults.blade.php`: قيم افتراضية موحدة لجدول DataTables بعربي (لغة، بحث، ترقيم، إلخ).
- **دمجها** في `layouts/admin.blade.php` عبر `@include` لتعريف `window.dtArabicAjaxDefaults`.
- **تحديث** `admin/clients/index.blade.php` لاستخدام `Object.assign({}, window.dtArabicAjaxDefaults, { ajax, columns })` بدل تكرار الخيارات نفسها.

صفحات الأدمن الأخرى التي تستخدم DataTables بـ Ajax (مثل employees، eventPackages، services index) يمكن أن تستخدم نفس النمط لاحقاً لتفادي التكرار.

---

## تنفيذ إضافي (الجولة الثانية)

### 5. توحيد لغة القائمة
- إضافة مفتاح **`global.menu`** في `resources/lang/fr/global.php` و`resources/lang/en/global.php` (عناصر القائمة: الحجوزات، التقويم، الباقات، البورتفوليو، FAQ، آراء العملاء، رسائل العملاء، الشركة، الموظفون، الخدمات، قاعات الأفراح، العملاء، إدارة المستخدمين، تسجيل الخروج).
- استبدال النصوص الثابتة في **`resources/views/partials/menu.blade.php`** بـ `{{ trans('global.menu.xxx') }}` لاعتماد لغة التطبيق (fr/en) بشكل موحّد.

### 6. تفعيل إدارة الخدمات
- إنشاء **`App\Models\Service`** (جدول `services`: name, price, description, image, soft deletes) مع علاقة `employees()` ومعامل `getPhotoAttribute()` للتوافق مع Dropzone.
- إنشاء **`App\Http\Controllers\Admin\ServiceController`** (index مع DataTables، create، store، edit، update، show، destroy، storeMedia، massDestroy) و**`App\Http\Requests\MassDestroyServiceRequest`**.
- إضافة المسارات في **`routes/admin.php`**: `POST services/media`، `DELETE services/destroy`، `Route::resource('services', ...)`.
- إضافة رابط **«الخدمات»** في القائمة الجانبية للأدمن (بعد الموظفين).
- حذف **`admin/services/README.md`** لأن الخدمات أصبحت مفعّلة.

### 7. توحيد تسمية مجلدات الـ views
- إعادة تسمية المجلدات: **eventPackages** → **event-packages**، **adpackages** → **ad-packages**، **eventlocations** → **event-locations**.
- إنشاء مجلد **portfolio-items** ونسخ كل views البورتفوليو إليه؛ تحديث **PortfolioItemsController** و**@include** في القوالب لاستخدام `admin.portfolio-items` و`admin.portfolio-items.partials.form`. (المجلد القديم `portfolioItems` يمكن حذفه يدوياً إذا لم يعد مستخدماً.)
- مسارات الـ routes لم تتغير (مثلاً `admin.eventlocations` ما زال يستخدم في الروابط).

---

## ما بقي (اختياري)

- **تم:** حذف مجلد **`resources/views/admin/portfolioItems`** (التكرار كان مع `portfolio-items`؛ المعتمد هو `portfolio-items` فقط).

---

## مراجع

- تفاصيل النقائص والإصلاحات السابقة: `AUDIT_REPORT.md`
- هيكل المشروع: `PROJECT_STRUCTURE.md` (إن وُجد)
