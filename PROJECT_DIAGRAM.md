# مخطط مشروع ONX-EDGE

مشروع **Laravel** لشركة إنتاج (فيديو/تصوير/تسويق) مع واجهة عامة، منطقة عملاء، ولوحة إدارة.

> **الهيكل التفصيلي (مجلدات وملفات):** انظر [PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md).

---

## 1. نظرة عامة على البنية

```
                    ┌─────────────────────────────────────────────────────────┐
                    │                    ONX-EDGE (Laravel)                     │
                    └─────────────────────────────────────────────────────────┘
                                              │
         ┌────────────────────────────────────┼────────────────────────────────────┐
         │                                    │                                    │
         ▼                                    ▼                                    ▼
┌─────────────────┐               ┌─────────────────────┐               ┌─────────────────────┐
│  الواجهة العامة   │               │   منطقة العملاء      │               │   لوحة الإدارة       │
│  (Front)         │               │   (Client Portal)   │               │   (Admin)           │
├─────────────────┤               ├─────────────────────┤               ├─────────────────────┤
│ /               │               │ /client/login       │               │ /admin (auth)       │
│ /portfolio      │               │ /client/            │               │ الحجوزات، العملاء،   │
│ /services/*     │               │ الحجوزات، الملفات،   │               │ الباقات، الموظفون،   │
│ /booking        │               │ الرسائل، الدفع،      │               │ المستخدمون، الصلاحيات │
│ /contact, /faq  │               │ الوسائط، الفاتورة    │               │                     │
└────────┬────────┘               └──────────┬──────────┘               └──────────┬──────────┘
         │                                   │                                    │
         └───────────────────────────────────┼────────────────────────────────────┘
                                             │
                              ┌──────────────▼──────────────┐
                              │  Models / DB / BookingService │
                              │  (Booking, Client, AdPackage,  │
                              │   EventPackage, BookingFile…)  │
                              └──────────────────────────────┘
```

---

## 2. المسارات (Routes)

| القسم | البادئة | الحراس | الملف |
|-------|---------|--------|-------|
| **الواجهة العامة** | `/`, `/portfolio`, `/services`, `/booking`, `/contact`, `/faq` | — | `routes/web.php` |
| **منطقة العملاء** | `/client/*` | `client.auth` (عميل مسجل) | `routes/web.php` |
| **لوحة الإدارة** | `/admin/*` | `auth` (مستخدم أدمن) | `routes/admin.php` |
| **تسجيل الأدمن** | `/login`, `/password/*` | — | `Auth::routes()` في `web.php` |

---

## 3. المتحكمات (Controllers)

| المجلد | الوظيفة |
|--------|---------|
| **Front\\** | الصفحة الرئيسية، الخدمات، البورتفوليو، الحجز، التواصل، FAQ |
| **Client\\** | AuthController (دخول العميل)، DashboardController (لوحة العميل، الحجوزات، الملفات، الدفع، الوسائط، الفاتورة) |
| **Admin\\** | الحجوزات (مع المدفوعات والملفات والصور)، العملاء، البورتفوليو، الباقات (Event/Ad)، المواقع، الموظفون، المستخدمون، الصلاحيات، الشركة، الرسائل، FAQ، الشهادات |
| **Auth\\** | تسجيل دخول/خروج وإعادة تعيين كلمة مرور مستخدمي الأدمن |

---

## 4. النماذج (Models) والعلاقات الأساسية

```
User (أدمن)          Client (عميل)
  │                     │
  └── Role, Permission  ├── Booking (1:n)
                        ├── ClientMessage
                        ├── ClientPhoto, ClientSelectedPhoto
                        └── ClientFile

Booking
  ├── belongs to: Client, EventPackage أو AdPackage (حسب service_type)
  ├── has many:   BookingPhoto, BookingPayment, BookingFile
  └── EventLocation (اختياري)

EventPackage, AdPackage   → باقات الخدمات (أحداث إعلانية)
EventLocation             → قاعات/مواقع الأحداث
PortfolioItem             → أعمال البورتفوليو
Employee                  → موظفو الشركة
Company, Faq, Testimonial  → محتوى الموقع
```

---

## 5. هيكل المجلدات الرئيسي

```
onx-edge/
├── app/
│   ├── Console/Commands/     # أوامر (مثل إلغاء الحجوزات المنتهية)
│   ├── Exceptions/
│   ├── Helpers/              # EditableHelper, helpers
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # لوحة التحكم
│   │   │   ├── Client/       # منطقة العملاء
│   │   │   ├── Front/        # الواجهة العامة
│   │   │   └── Auth/         # دخول الأدمن
│   │   ├── Middleware/       # AuthGates, RedirectIfNotClient, client.auth
│   │   ├── Requests/         # التحقق من النماذج (Store/Update)
│   │   └── Resources/Admin/   # API Resources
│   ├── Mail/                 # BookingConfirmationMail, ContactFormMail
│   ├── Models/               # Booking, Client, User, AdPackage, …
│   ├── Providers/
│   └── Services/             # BookingService (إنشاء حجز/عميل)
├── config/                   # app, auth (guards: web, client), database, …
├── database/
│   ├── migrations/           # الجداول + التعديلات الحديثة (payments, files, client_files)
│   ├── seeders/
│   └── factories/
├── public/                   # index.php, أصول مُبنية
├── resources/
│   ├── css/, js/             # أصول الواجهة (Vite, Tailwind, Alpine)
│   ├── lang/                 # en, fr
│   └── views/
│       ├── layouts/          # admin, front_tailwind, client_portal
│       ├── front/            # الصفحات العامة + booking, services
│       ├── client/           # لوحة العميل (dashboard, bookings, files, …)
│       ├── admin/            # صفحات لوحة التحكم (bookings, clients, …)
│       ├── auth/             # تسجيل دخول الأدمن
│       ├── emails/
│       └── partials/
├── routes/
│   ├── web.php               # الواجهة + منطقة العملاء
│   ├── admin.php             # لوحة الإدارة
│   └── api.php
├── storage/
└── .env, artisan, composer.json, package.json, vite.config.js
```

---

## 6. تدفق الحجز (من الواجهة إلى العميل)

1. **الواجهة:** `/booking` → نموذج الحجز (تاريخ، باقة، بيانات العميل).
2. **Front\BookingController::store** → يستدعي **BookingService** (findOrCreateClient, createBooking).
3. بعد الحفظ: إعادة توجيه إلى `/booking/confirmation/{booking}` و/أو PDF.
4. العميل يدخل إلى منطقة العملاء عبر `/client/login` (بريد/هاتف + كلمة سر) أو رابط تعيين كلمة السر.
5. من لوحة العميل: عرض الحجوزات، الملفات، المدفوعات، الوسائط، الفاتورة، تحميل ZIP للصور المميزة.

---

## 7. ملخص سريع

| المكون | التقنية / الملاحظات |
|--------|----------------------|
| الإطار | Laravel 9, PHP 8.1+ |
| الواجهة الأمامية | Vite, Tailwind, Alpine.js |
| المصادقة | حراس: `web` (أدمن), `client` (عميل) في `config/auth.php` |
| الحجز والعميل | `BookingService`, `Front\BookingController`, `Client\DashboardController` |
| إدارة الحجوزات | `Admin\BookingsController` + BookingPayments, BookingFiles, BookingPhotos |

---

*تم إنشاء هذا المخطط لوصف بنية مشروع ONX-EDGE.*
