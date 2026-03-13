# هيكل مشروع ONX-EDGE

مشروع Laravel 9 (PHP 8.1+) مع Vite و Tailwind و Alpine.js.

---

## الجذر

```
onx-edge/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

## app/ — منطق التطبيق

```
app/
├── Console/
│   ├── Kernel.php
│   └── Commands/
│       └── CancelExpiredPendingBookings.php
├── Exceptions/
│   └── Handler.php
├── Helpers/
│   └── EditableHelper.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # لوحة التحكم
│   │   │   ├── AdPackagesController.php
│   │   │   ├── BookingsCalendarController.php
│   │   │   ├── BookingsController.php
│   │   │   ├── BookingPhotosController.php
│   │   │   ├── ClientsController.php
│   │   │   ├── ClientMessagesController.php
│   │   │   ├── CompanyController.php
│   │   │   ├── EmployeesController.php
│   │   │   ├── EventLocationController.php
│   │   │   ├── EventPackagesController.php
│   │   │   ├── FaqController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PermissionsController.php
│   │   │   ├── PortfolioItemsController.php
│   │   │   ├── RolesController.php
│   │   │   ├── TestimonialController.php
│   │   │   ├── UsersController.php
│   │   │   └── ...
│   │   ├── Client/             # منطقة العملاء
│   │   │   ├── AuthController.php
│   │   │   └── DashboardController.php
│   │   ├── Front/              # الواجهة العامة
│   │   │   ├── BookingController.php
│   │   │   ├── ContactController.php
│   │   │   ├── FaqController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PortfolioController.php
│   │   │   └── ServiceController.php
│   │   ├── Auth/               # تسجيل دخول الأدمن
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   ├── ResetPasswordController.php
│   │   │   └── VerificationController.php
│   │   ├── Traits/
│   │   │   └── MediaUploadingTrait.php
│   │   └── Controller.php
│   ├── Middleware/
│   │   ├── RedirectIfNotClient.php   # حماية منطقة العملاء
│   │   ├── AuthGates.php
│   │   ├── Authenticate.php
│   │   ├── EncryptCookies.php
│   │   ├── VerifyCsrfToken.php
│   │   ├── SetLocale.php
│   │   ├── TrimStrings.php
│   │   ├── TrustProxies.php
│   │   ├── OnlyIframe.php
│   │   ├── RedirectIfAuthenticated.php
│   │   └── CheckForMaintenanceMode.php
│   ├── Requests/               # Form Requests (Admin)
│   │   ├── StoreClientRequest.php, UpdateClientRequest.php
│   │   ├── StoreUserRequest.php, UpdateUserRequest.php
│   │   ├── StoreRoleRequest.php, UpdateRoleRequest.php
│   │   ├── StorePermissionRequest.php, UpdatePermissionRequest.php
│   │   ├── StoreEmployeeRequest.php, UpdateEmployeeRequest.php
│   │   ├── MassDestroyUserRequest.php, MassDestroyClientRequest.php
│   │   └── ...
│   ├── Resources/Admin/        # API Resources
│   │   ├── ClientResource.php
│   │   ├── UserResource.php
│   │   ├── RoleResource.php
│   │   ├── PermissionResource.php
│   │   ├── EmployeeResource.php
│   │   └── ServiceResource.php
│   └── Kernel.php
├── Mail/
│   ├── BookingConfirmationMail.php
│   └── ContactFormMail.php
├── Models/
│   ├── Booking.php
│   ├── Client.php
│   ├── ClientMessage.php
│   ├── ClientPhoto.php
│   ├── ClientSelectedPhoto.php
│   ├── BookingPhoto.php
│   ├── Testimonial.php
│   ├── Faq.php
│   ├── Adpackage.php
│   ├── EventPackage.php
│   ├── EventLocation.php
│   ├── PortfolioItem.php
│   ├── EditableContent.php
│   ├── Company.php
│   ├── Employee.php
│   ├── User.php
│   ├── Role.php
│   ├── Permission.php
│   └── ...
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── RouteServiceProvider.php
│   ├── EventServiceProvider.php
│   └── BroadcastServiceProvider.php
└── Services/
    └── BookingService.php      # findOrCreateClient, createBooking, getBookingMeta
```

---

## config/ — الإعدادات

```
config/
├── app.php
├── auth.php        # حراس web و client
├── database.php
├── filesystems.php
├── mail.php
├── view.php
├── session.php
├── cache.php
├── queue.php
├── logging.php
├── cors.php
├── hashing.php
├── services.php
├── sanctum.php
└── broadcasting.php
```

---

## database/ — قاعدة البيانات

```
database/
├── migrations/
│   ├── create_clients_table, create_bookings_table, ...
│   ├── create_faqs_table, create_testimonials_table
│   ├── create_client_messages_table, create_client_photos_table
│   ├── create_booking_photos_table, create_client_selected_photos_table
│   ├── add_client_auth_to_clients_table
│   ├── add_login_disabled_to_clients_table
│   ├── add_final_video_to_bookings_table
│   ├── fix_booking_service_type_from_package_type
│   ├── create_event_packages_table, create_ad_packages_table
│   ├── create_portfolio_items_table, create_event_locations_table
│   └── ...
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── UsersTableSeeder.php, RolesTableSeeder.php, PermissionsTableSeeder.php
│   ├── ClientsTableSeeder.php, CompanySeeder.php
│   ├── FaqTestimonialSeeder.php
│   └── ...
└── factories/
    ├── UserFactory.php
    ├── ClientFactory.php
    ├── EmployeeFactory.php
    ├── ServiceFactory.php
    └── AppointmentFactory.php
```

---

## routes/ — المسارات

```
routes/
├── web.php      # الواجهة العامة + منطقة العملاء (/client/*)
├── admin.php    # لوحة التحكم (/admin/*)
├── api.php
├── channels.php
└── console.php
```

- **الواجهة:** الصفحة الرئيسية، الخدمات، بورتفوليو، تواصل، FAQ، الحجز.
- **منطقة العملاء (client.\*):** تسجيل الدخول (بريد/هاتف + كلمة سر)، لوحة التحكم، الملف الشخصي، حجوزاتي، رسائل، إضافة رأي، صور المشروع.
- **لوحة التحكم (admin.\*):** حجوزات، عملاء، آراء، رسائل العملاء، باقات، تقويم، مستخدمين، صلاحيات، إلخ.

---

## resources/ — الأصول والواجهات

```
resources/
├── css/
├── js/
│   ├── app.js
│   ├── bootstrap.js
│   ├── front/
│   │   ├── booking.js
│   │   ├── portfolio.js
│   │   └── portfolio-works-grid.js
│   └── admin/
│       └── portfolio-form.js
└── views/
    ├── layouts/
    │   ├── front_tailwind.blade.php   # تخطيط الواجهة العامة
    │   ├── admin.blade.php            # تخطيط لوحة التحكم
    │   ├── app.blade.php
    │   └── mail.blade.php
    ├── front/                         # الصفحات العامة
    │   ├── home.blade.php
    │   ├── contact.blade.php
    │   ├── faq.blade.php
    │   ├── portfolio.blade.php
    │   ├── services/
    │   │   ├── index.blade.php
    │   │   ├── events.blade.php
    │   │   └── marketing.blade.php
    │   └── booking/
    │       ├── index.blade.php        # نموذج الحجز
    │       ├── confirmation.blade.php # تأكيد الحجز + بيانات الدخول
    │       └── pdf.blade.php          # PDF الحجز
    ├── client/                        # منطقة العملاء
    │   ├── layout.blade.php
    │   ├── dashboard.blade.php
    │   ├── profile.blade.php
    │   ├── bookings.blade.php
    │   ├── booking-detail.blade.php
    │   ├── messages.blade.php
    │   ├── review-create.blade.php
    │   ├── photos.blade.php
    │   ├── project-photos.blade.php
    │   ├── project-photos-booking.blade.php
    │   └── auth/
    │       ├── login.blade.php
    │       └── set-password.blade.php
    ├── admin/                         # لوحة التحكم
    │   ├── bookings/ (index, show, calendar)
    │   ├── clients/ (index, show, create, edit)
    │   ├── testimonials/ (index, create, edit)
    │   ├── client-messages/ (index)
    │   ├── faqs/ (index, create, edit)
    │   ├── portfolio-items/ (index, create, edit, show, partials/form)
    │   ├── eventPackages/, adpackages/
    │   ├── eventlocations/
    │   ├── company/, employees/
    │   ├── users/, services/
    │   └── ...
    ├── auth/                          # تسجيل دخول الأدمن
    │   ├── login.blade.php
    │   └── passwords/ (email, reset)
    ├── emails/
    │   ├── booking_confirmation.blade.php
    │   └── contact_form.blade.php
    ├── partials/
    │   ├── menu.blade.php
    │   ├── datatablesActions.blade.php
    │   ├── datatablesActionsClients.blade.php
    │   └── portfolio-works-grid.blade.php
    └── home.blade.php
```

---

## public/

```
public/
├── js/
│   └── booking.js    # أصول مُبناة أو منسوخة للحجز
├── css/
├── storage -> ../storage/app/public
├── index.php
└── ...
```

---

## ملخص المسارات والمسؤوليات

| القسم            | المسارات      | المتحكمات           | الوصف |
|------------------|---------------|---------------------|--------|
| الواجهة العامة   | في web.php    | Front\*             | الرئيسية، خدمات، بورتفوليو، تواصل، FAQ، الحجز |
| منطقة العملاء     | /client/*     | Client\AuthController, Client\DashboardController | دخول، لوحة، حجوزاتي، رسائل، رأي، صور مشروع |
| لوحة التحكم      | /admin/*      | Admin\*             | حجوزات، عملاء، آراء، رسائل، باقات، تقويم، مستخدمين |
| تسجيل الأدمن     | /login (admin)| Auth\LoginController| دخول مستخدمي لوحة التحكم |

---

## ملفات مهمة للمراجعة

- **الحجز والعميل:** `app/Services/BookingService.php`, `app/Http/Controllers/Front/BookingController.php`, `app/Http/Controllers/Client/`
- **عرض الباقة في الحجز:** يعتمد على `service_type` و `getBookingMeta()` (EventPackage أو AdPackage).
- **حراس الدخول:** `config/auth.php` (guards: web, client).

تم إنشاء هذا الملف تلقائياً لوصف هيكل المشروع.
