<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول — ONX</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { height: 100%; }
        body { min-height: 100%; }
        body { font-family: 'Cairo', sans-serif; background: #060606; color: #fff; -webkit-font-smoothing: antialiased; }

        /* ── LAYOUT ── */
        .page { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
        @media (max-width: 1023px) { .page { grid-template-columns: 1fr; } .vis-panel { display: none; } }

        /* ── LEFT — VISUAL ── */
        .vis-panel { position: relative; background: #080808; overflow: hidden; display: flex; flex-direction: column; }
        .vis-glow-top { position: absolute; top: -80px; left: -80px; width: 500px; height: 500px; border-radius: 50%; background: radial-gradient(circle, rgba(249,115,22,.18) 0%, transparent 70%); pointer-events: none; }
        .vis-glow-bottom { position: absolute; bottom: -100px; right: -60px; width: 380px; height: 380px; border-radius: 50%; background: radial-gradient(circle, rgba(234,88,12,.1) 0%, transparent 70%); pointer-events: none; }
        .vis-grid { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px); background-size: 40px 40px; }
        .vis-inner { position: relative; z-index: 1; display: flex; flex-direction: column; height: 100%; padding: 2.5rem; }
        .vis-logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .vis-logo-text { font-size: 20px; font-weight: 900; letter-spacing: .18em; color: #fff; }
        .vis-logo-dot { width: 9px; height: 9px; border-radius: 50%; background: #f97316; box-shadow: 0 0 18px rgba(249,115,22,.85); display: inline-block; flex-shrink: 0; }
        .preview-wrap { flex: 1; display: flex; align-items: center; justify-content: center; padding: 2rem 0; }
        .preview-card { width: 100%; max-width: 340px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.09); border-radius: 20px; padding: 1.25rem; animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .pc-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: .875rem; padding-bottom: .75rem; border-bottom: 1px solid rgba(255,255,255,.07); }
        .pc-head-title { font-size: 12.5px; font-weight: 800; color: rgba(255,255,255,.8); }
        .pc-badge { font-size: 9.5px; font-weight: 700; padding: 3px 9px; border-radius: 20px; background: rgba(249,115,22,.17); color: #fb923c; }
        .pc-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: .4rem; margin-bottom: .875rem; }
        .pc-stat { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.06); border-radius: 12px; padding: .55rem .4rem; text-align: center; }
        .pc-stat-val { font-size: 17px; font-weight: 900; color: #fff; line-height: 1; margin-bottom: 3px; }
        .pc-stat-lbl { font-size: 9px; color: rgba(255,255,255,.38); font-weight: 700; }
        .pc-bars { display: flex; flex-direction: column; gap: .4rem; }
        .pc-bar-item { display: flex; align-items: center; gap: .5rem; }
        .pc-bar-lbl { font-size: 10.5px; color: rgba(255,255,255,.45); min-width: 52px; }
        .pc-bar-track { flex:1; height: 4px; background: rgba(255,255,255,.07); border-radius: 10px; overflow:hidden; }
        .pc-bar-fill { height: 100%; background: linear-gradient(90deg, #f97316, #fb923c); border-radius: 10px; transform-origin: right; animation: barGrow 1.4s cubic-bezier(.34,1.56,.64,1) both; }
        @keyframes barGrow { from{transform:scaleX(0)} to{transform:scaleX(1)} }
        .ben-label { font-size: 10px; font-weight: 700; letter-spacing: .1em; color: rgba(255,255,255,.28); margin-bottom: .75rem; }
        .ben-list { display: flex; flex-direction: column; gap: .65rem; list-style: none; }
        .ben-item { display: flex; align-items: flex-start; gap: .7rem; }
        .ben-icon { flex-shrink: 0; width: 32px; height: 32px; border-radius: 10px; background: rgba(249,115,22,.13); border: 1px solid rgba(249,115,22,.22); display: flex; align-items: center; justify-content: center; color: #fb923c; font-size: 14px; margin-top: 1px; }
        .ben-body strong { display: block; font-size: 12.5px; font-weight: 800; color: rgba(255,255,255,.82); margin-bottom: 1px; }
        .ben-body span { font-size: 11.5px; color: rgba(255,255,255,.42); line-height: 1.45; }
        .vis-bottom { margin-top: 2rem; display: flex; align-items: center; gap: .5rem; }
        .vis-bottom-line { flex:1; height:1px; background:rgba(255,255,255,.07); }
        .vis-bottom-text { font-size: 11px; color: rgba(255,255,255,.2); white-space: nowrap; }

        /* ── RIGHT — FORM PANEL ── */
        .form-panel { display: flex; flex-direction: column; justify-content: flex-start; align-items: center; background: #060606; padding: 5rem 2rem 4rem; position: relative; }
        .form-panel::before { content: ''; position: absolute; top: -60px; right: -60px; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(249,115,22,.07) 0%, transparent 70%); pointer-events: none; }
        .form-inner { width: 100%; max-width: 400px; position: relative; z-index: 1; }
        .back-link { position: absolute; top: 1.5rem; left: 1.5rem; display: flex; align-items: center; gap: .4rem; font-size: 12px; font-weight: 700; color: rgba(255,255,255,.3); text-decoration: none; transition: color .15s; z-index: 2; }
        .back-link:hover { color: rgba(255,255,255,.65); }
        .mobile-logo { display: none; align-items: center; gap: 8px; margin-bottom: 2rem; text-decoration: none; }
        .mobile-logo-text { font-size: 18px; font-weight: 900; letter-spacing: .18em; color: #fff; }
        .mobile-logo-dot { width: 8px; height: 8px; border-radius: 50%; background: #f97316; box-shadow: 0 0 14px rgba(249,115,22,.8); }
        @media (max-width: 1023px) { .mobile-logo { display: flex; } }

        /* ── WELCOME ── */
        .welcome { margin-bottom: 1.75rem; }
        .welcome h1 { font-size: 26px; font-weight: 900; color: #fff; margin-bottom: .4rem; line-height: 1.2; }
        .welcome p { font-size: 13.5px; color: rgba(255,255,255,.42); line-height: 1.6; }

        /* ── ALERTS ── */
        .error-alert { margin-bottom: 1.25rem; padding: .875rem 1rem; border-radius: 14px; border: 1px solid rgba(239,68,68,.28); background: rgba(239,68,68,.07); font-size: 13px; color: #fca5a5; }
        .error-alert p { font-weight: 700; }
        .success-alert { margin-bottom: 1rem; padding: .75rem 1rem; border-radius: 12px; border: 1px solid rgba(34,197,94,.22); background: rgba(34,197,94,.07); font-size: 13px; color: #86efac; font-weight: 700; }

        /* ── MAIN LOGIN CARD ── */
        .login-card { background: rgba(255,255,255,.035); border: 1px solid rgba(255,255,255,.08); border-radius: 24px; padding: 1.75rem; transition: border-color .3s; }
        .login-card.recovery-open { border-color: rgba(249,115,22,.2); border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
        .card-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: .1em; color: rgba(255,255,255,.28); margin-bottom: 1.25rem; }

        /* ── FIELDS ── */
        .field { margin-bottom: 1rem; }
        .field label { display: block; font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.72); margin-bottom: .45rem; }
        .field-input { width: 100%; background: rgba(255,255,255,.04); border: 1.5px solid rgba(255,255,255,.1); border-radius: 14px; padding: .75rem 1rem; color: #fff; font-size: 13.5px; font-family: 'Cairo', sans-serif; outline: none; transition: border-color .2s, background .2s, box-shadow .2s; }
        .field-input::placeholder { color: rgba(255,255,255,.22); }
        .field-input:hover { border-color: rgba(255,255,255,.18); }
        .field-input:focus { border-color: rgba(249,115,22,.55); background: rgba(249,115,22,.03); box-shadow: 0 0 0 4px rgba(249,115,22,.09); }
        .field-input.has-error { border-color: rgba(239,68,68,.45); }
        .field-error { margin-top: .35rem; font-size: 11.5px; color: #f87171; }
        .pw-wrap { position: relative; }
        .pw-wrap .field-input { padding-left: 3rem; }
        .pw-toggle { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: none; background: transparent; color: rgba(255,255,255,.35); border-radius: 10px; cursor: pointer; font-size: 15px; transition: color .15s, background .15s; }
        .pw-toggle:hover { color: #fff; background: rgba(255,255,255,.07); }
        .bottom-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; flex-wrap: wrap; gap: .5rem; }
        .remember-label { display: flex; align-items: center; gap: .45rem; font-size: 12.5px; color: rgba(255,255,255,.52); cursor: pointer; }
        .remember-label input { accent-color: #f97316; width: 15px; height: 15px; cursor: pointer; }

        /* ── FORGOT TRIGGER BUTTON ── */
        .forgot-trigger {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: 12.5px;
            font-weight: 700;
            color: #fb923c;
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            padding: 0;
            transition: color .15s;
            line-height: 1;
        }
        .forgot-trigger:hover { color: #fdba74; }
        .forgot-trigger .ft-arrow {
            font-size: 11px;
            transition: transform .3s ease;
        }
        .forgot-trigger.open .ft-arrow { transform: rotate(180deg); }

        /* ── PRIMARY BUTTON ── */
        .btn-primary { width: 100%; padding: .875rem; border-radius: 100px; border: none; background: #f97316; color: #000; font-size: 15px; font-weight: 900; font-family: 'Cairo', sans-serif; cursor: pointer; box-shadow: 0 4px 24px rgba(249,115,22,.26); transition: background .2s, transform .1s, box-shadow .2s; display: flex; align-items: center; justify-content: center; gap: .45rem; }
        .btn-primary:hover { background: #fb923c; box-shadow: 0 6px 30px rgba(249,115,22,.36); }
        .btn-primary:active { transform: scale(0.98); }
        .btn-primary:disabled { opacity: .6; cursor: not-allowed; transform: none; }
        .btn-spinner { display: none; width: 17px; height: 17px; border: 2.5px solid rgba(0,0,0,.22); border-top-color: #000; border-radius: 50%; animation: spin .7s linear infinite; flex-shrink: 0; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-primary.loading .btn-spinner { display: block; }
        .btn-primary.loading .btn-label { opacity: .7; }

        /* ════════════════════════════════════════════
           ACCORDION — الاسترجاع ينزل أسفل الكارت
        ════════════════════════════════════════════ */
        .recovery-accordion {
            display: none;
            border: 1px solid rgba(249,115,22,.2);
            border-top: none;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
            background: rgba(249,115,22,.02);
        }
        .recovery-accordion.open {
            display: block;
        }
        .recovery-inner { padding: 1.5rem 1.75rem 1.75rem; }

        /* step pills */
        .step-pills { display: flex; align-items: center; gap: .35rem; margin-bottom: 1.25rem; }
        .step-pill { height: 4px; border-radius: 100px; background: rgba(255,255,255,.1); flex: 1; transition: background .3s; }
        .step-pill.active { background: #f97316; }
        .step-pill.done   { background: rgba(34,197,94,.5); }

        /* ── الخطوات: العرض يتحكم به الجافاسكربت فقط (inline style) ── */
        #rec-step-success { display: none; }

        /* تعليمات الكود — أوضح أن الكود من البريد */
        .otp-instruction { font-size: 12px; color: rgba(255,255,255,.55); text-align: center; margin-bottom: 1rem; padding: .6rem .75rem; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; line-height: 1.5; }
        .otp-instruction strong { color: #fb923c; }

        /* ── OTP boxes (المربعات الـ 6 للكود) — تظهر كلها في صف واحد ── */
        .otp-row { display: flex !important; gap: .35rem; justify-content: center; align-items: center; direction: ltr; margin-bottom: .75rem; min-height: 52px; flex-wrap: nowrap; overflow: visible; }
        .otp-box { width: 42px; height: 50px; min-width: 38px; background: rgba(255,255,255,.08); border: 1.5px solid rgba(255,255,255,.18); border-radius: 10px; text-align: center; font-size: 20px; font-weight: 900; color: #fff; font-family: 'Cairo', sans-serif; outline: none; transition: border-color .2s, box-shadow .2s; caret-color: #f97316; -webkit-appearance: none; appearance: none; flex-shrink: 0; }
        .otp-box:focus { border-color: rgba(249,115,22,.6); box-shadow: 0 0 0 3px rgba(249,115,22,.12); }
        .otp-box.err { border-color: rgba(239,68,68,.5); background: rgba(239,68,68,.06); }
        @media (max-width: 380px) { .otp-box { width: 36px; height: 46px; min-width: 32px; font-size: 18px; } .otp-row { gap: .25rem; } }

        /* countdown */
        .countdown-row { text-align: center; font-size: 11.5px; color: rgba(255,255,255,.28); margin-bottom: 1rem; }
        .countdown-row b { color: rgba(249,115,22,.75); }

        /* separator */
        .sep { height: 1px; background: rgba(255,255,255,.07); margin: 1rem 0; }

        /* resend */
        .resend-row { display: flex; align-items: center; justify-content: center; gap: .4rem; margin-top: .875rem; font-size: 12px; color: rgba(255,255,255,.3); }
        .resend-btn { background: none; border: none; color: #fb923c; font-weight: 700; font-family: 'Cairo', sans-serif; font-size: 12px; cursor: pointer; padding: 0; transition: color .15s; }
        .resend-btn:hover { color: #fdba74; }
        .resend-btn:disabled { opacity: .45; cursor: not-allowed; }

        .otp-verified-msg { font-size: 12px; color: rgba(34,197,94,.9); margin-bottom: 1rem; padding: .5rem 0; font-weight: 700; }
        .rec-password-section { animation: fadeIn .35s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* back step */
        .back-step { display: flex; align-items: center; gap: .3rem; font-size: 12px; color: rgba(255,255,255,.3); background: none; border: none; cursor: pointer; font-family: 'Cairo', sans-serif; padding: 0; margin-bottom: 1rem; transition: color .15s; }
        .back-step:hover { color: rgba(255,255,255,.6); }

        /* success mini */
        .success-mini { text-align: center; padding: .5rem 0 .25rem; }
        .success-mini .check-circle { width: 52px; height: 52px; border-radius: 50%; background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.25); display: flex; align-items: center; justify-content: center; margin: 0 auto .875rem; font-size: 22px; color: #86efac; }
        .success-mini h3 { font-size: 17px; font-weight: 900; color: #fff; margin-bottom: .35rem; }
        .success-mini p { font-size: 12.5px; color: rgba(255,255,255,.42); margin-bottom: 1rem; }
        .progress-bar-wrap { height: 3px; border-radius: 100px; background: rgba(255,255,255,.07); overflow: hidden; }
        .progress-bar-fill { height: 100%; background: linear-gradient(90deg, #f97316, #fb923c); border-radius: 100px; width: 0; transition: width 2s linear; }

        /* ── DIVIDER + FOOTER ── */
        .divider { height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,.07), transparent); margin: 1.4rem 0; }
        .register-hint { text-align: center; font-size: 12.5px; color: rgba(255,255,255,.35); }
        .register-hint a { color: #fb923c; font-weight: 700; text-decoration: none; transition: color .15s; }
        .register-hint a:hover { color: #fdba74; }
        .form-note { margin-top: 1rem; text-align: center; font-size: 11.5px; color: rgba(255,255,255,.2); line-height: 1.55; }

        /* ── FADE UP ── */
        .fade-up { opacity: 0; transform: translateY(14px); animation: fadeUp .5s ease forwards; }
        .fu-d1{animation-delay:.06s} .fu-d2{animation-delay:.14s} .fu-d3{animation-delay:.22s}
        @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
<div class="page">

    {{-- ══════════════ LEFT — Visual ══════════════ --}}
    <div class="vis-panel" aria-hidden="true">
        <div class="vis-glow-top"></div>
        <div class="vis-glow-bottom"></div>
        <div class="vis-grid"></div>
        <div class="vis-inner">
            <a href="{{ url('/') }}" class="vis-logo">
                <span class="vis-logo-text">ONX</span>
                <span class="vis-logo-dot"></span>
            </a>
            <div class="preview-wrap">
                <div class="preview-card">
                    <div class="pc-head">
                        <span class="pc-head-title">لوحة التحكم</span>
                        <span class="pc-badge">● مباشر</span>
                    </div>
                    <div class="pc-stats">
                        <div class="pc-stat"><div class="pc-stat-val">4</div><div class="pc-stat-lbl">مشاريع</div></div>
                        <div class="pc-stat"><div class="pc-stat-val">12</div><div class="pc-stat-lbl">ملفات</div></div>
                        <div class="pc-stat"><div class="pc-stat-val">3</div><div class="pc-stat-lbl">فواتير</div></div>
                    </div>
                    <div class="pc-bars">
                        <div class="pc-bar-item"><span class="pc-bar-lbl">التصوير</span><div class="pc-bar-track"><div class="pc-bar-fill" style="width:82%"></div></div></div>
                        <div class="pc-bar-item"><span class="pc-bar-lbl">المونتاج</span><div class="pc-bar-track"><div class="pc-bar-fill" style="width:56%;animation-delay:.15s"></div></div></div>
                        <div class="pc-bar-item"><span class="pc-bar-lbl">التسليم</span><div class="pc-bar-track"><div class="pc-bar-fill" style="width:31%;animation-delay:.3s"></div></div></div>
                    </div>
                </div>
            </div>
            <div>
                <p class="ben-label">لماذا تسجّل الدخول؟</p>
                <ul class="ben-list">
                    <li class="ben-item"><span class="ben-icon"><i class="bi bi-kanban"></i></span><div class="ben-body"><strong>تتبع مشاريعك</strong><span>راقب حالة كل مشروع وحجز.</span></div></li>
                    <li class="ben-item"><span class="ben-icon"><i class="bi bi-folder2-open"></i></span><div class="ben-body"><strong>وصول للملفات</strong><span>استعرض الوسائط والفواتير.</span></div></li>
                    <li class="ben-item"><span class="ben-icon"><i class="bi bi-chat-dots"></i></span><div class="ben-body"><strong>تواصل مع الفريق</strong><span>راسلنا وأدر حسابك بأمان.</span></div></li>
                    <li class="ben-item"><span class="ben-icon"><i class="bi bi-receipt"></i></span><div class="ben-body"><strong>إدارة الفواتير</strong><span>تتبع جميع فواتيرك.</span></div></li>
                </ul>
                <div class="vis-bottom"><div class="vis-bottom-line"></div><span class="vis-bottom-text">onx-edge.com</span><div class="vis-bottom-line"></div></div>
            </div>
        </div>
    </div>

    {{-- ══════════════ RIGHT — Form ══════════════ --}}
    <div class="form-panel">
        <a href="{{ url('/') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            العودة للموقع
        </a>

        <div class="form-inner">

            <a href="{{ url('/') }}" class="mobile-logo">
                <span class="mobile-logo-text">ONX</span>
                <span class="mobile-logo-dot"></span>
            </a>

            {{-- Welcome --}}
            <div class="welcome fade-up fu-d1">
                <h1>مرحباً بعودتك 👋</h1>
                <p>سجّل دخولك للوصول إلى مشاريعك وملفاتك وفواتيرك.</p>
            </div>

            {{-- Login errors --}}
            @if ($errors->any())
            <div role="alert" class="error-alert fade-up fu-d1">
                <p>{{ $errors->first('login') ?: $errors->first('password') ?: 'بيانات الدخول غير صحيحة.' }}</p>
                @if($errors->has('throttle'))
                    <p style="margin-top:.35rem;font-size:12px;opacity:.8;">{{ $errors->first('throttle') }}</p>
                @endif
            </div>
            @endif

            {{-- ════════════════════════════
                 MAIN LOGIN CARD
            ════════════════════════════ --}}
            <div class="login-card fade-up fu-d2" id="login-card">
                <p class="card-eyebrow">منطقة العملاء</p>

                <form method="POST" action="{{ route('client.login.post') }}" autocomplete="on" id="login-form">
                    @csrf
                    <div class="field">
                        <label for="login-field">البريد الإلكتروني أو رقم الهاتف</label>
                        <input
                            type="text" id="login-field" name="login"
                            value="{{ old('login') }}" autocomplete="username email" required
                            placeholder="example@email.com أو 05xxxxxxxx"
                            class="field-input @error('login') has-error @enderror"
                        />
                        @error('login')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label for="pw-field">كلمة المرور</label>
                        <div class="pw-wrap">
                            <input
                                type="password" id="pw-field" name="password"
                                autocomplete="current-password" required placeholder="••••••••"
                                class="field-input @error('password') has-error @enderror"
                            />
                            <button type="button" class="pw-toggle" id="pw-toggle" aria-label="إظهار كلمة المرور" aria-pressed="false">
                                <i id="eye-show" class="bi bi-eye"></i>
                                <i id="eye-hide" class="bi bi-eye-slash" style="display:none;"></i>
                            </button>
                        </div>
                        @error('password')<p class="field-error" role="alert">{{ $message }}</p>@enderror
                    </div>

                    <div class="bottom-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" value="1"> تذكرني
                        </label>
                        {{-- زر الاسترجاع — يفتح الـ accordion --}}
                        <button type="button" class="forgot-trigger" id="forgot-trigger" aria-expanded="false" aria-controls="recovery-accordion">
                            نسيت كلمة مرورك؟
                            <i class="bi bi-chevron-down ft-arrow"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-primary" id="login-btn">
                        <span class="btn-spinner"></span>
                        <span class="btn-label">تسجيل الدخول</span>
                    </button>
                </form>
            </div>

            {{-- ════════════════════════════
                 ACCORDION — ينزل مباشرةً تحت الكارت
            ════════════════════════════ --}}
            <div class="recovery-accordion" id="recovery-accordion" role="region" aria-label="استرجاع كلمة المرور">
                <div class="recovery-inner">

                    {{-- Step pills --}}
                    <div class="step-pills">
                        <div class="step-pill active" id="pill-1"></div>
                        <div class="step-pill" id="pill-2"></div>
                        <div class="step-pill" id="pill-3"></div>
                    </div>

                    {{-- ── STEP 1: إدخال البريد ── --}}
                    <div id="rec-step-1">
                        <p style="font-size:12.5px;color:rgba(255,255,255,.5);margin-bottom:.875rem;line-height:1.5;">
                            أدخل بريدك الإلكتروني وسنرسل لك كود التحقق.
                        </p>
                        <div id="rec-error-1"></div>
                        <div class="field">
                            <label for="rec-email">البريد الإلكتروني</label>
                            <input
                                type="email" id="rec-email" autocomplete="email"
                                placeholder="example@email.com"
                                class="field-input"
                            />
                            <p id="rec-email-err" class="field-error" style="display:none;"></p>
                        </div>
                        <button type="button" class="btn-primary" id="send-otp-btn">
                            <span class="btn-spinner" id="send-spin"></span>
                            <span class="btn-label">إرسال الكود</span>
                        </button>
                    </div>

                    {{-- رأس الخطوة 2 (تغيير البريد + أخطاء) ──}}
                    <div id="rec-step-2-head">
                        <button type="button" class="back-step" id="back-to-step1">
                            <i class="bi bi-arrow-right" style="font-size:11px;"></i>
                            تغيير البريد
                        </button>
                        <div id="rec-error-2"></div>
                    </div>

                    {{-- دور 1: المربعات الستة + المؤقت + إعادة الإرسال ──}}
                    <div id="rec-otp-block">
                        <p class="otp-instruction" id="otp-instruction">
                            تحقّق من بريدك الإلكتروني — أدخل الكود المكوّن من <strong>6 أرقام</strong> في المربعات الستة أدناه.
                        </p>
                        <div class="field" style="margin-bottom:.5rem;">
                            <label style="text-align:center;display:block;margin-bottom:.5rem;font-size:12.5px;font-weight:700;color:rgba(255,255,255,.72);">
                                الكود المرسل إلى <span id="otp-sent-to" style="color:#fb923c;"></span>
                            </label>
                            <div class="otp-row" id="otp-row">
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="0" autocomplete="off" aria-label="رقم 1"/>
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="1" autocomplete="off" aria-label="رقم 2"/>
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="2" autocomplete="off" aria-label="رقم 3"/>
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="3" autocomplete="off" aria-label="رقم 4"/>
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="4" autocomplete="off" aria-label="رقم 5"/>
                                <input type="text" inputmode="numeric" maxlength="1" class="otp-box" data-i="5" autocomplete="off" aria-label="رقم 6"/>
                            </div>
                            <div class="countdown-row">الكود صالح لـ <b id="countdown">10:00</b></div>
                        </div>
                        <div class="resend-row" id="rec-resend-row">
                            لم يصلك الكود؟
                            <button type="button" class="resend-btn" id="resend-btn">إعادة الإرسال</button>
                            <span id="resend-cd" style="font-size:11px;display:none;">(<span id="resend-sec">120</span>ث)</span>
                        </div>
                    </div>

                    {{-- دور 2: إعادة التعيين ──}}
                    <div id="rec-password-block">
                        <p class="otp-verified-msg">تم التحقق من الكود. أدخل كلمة المرور الجديدة أدناه.</p>
                        <div class="field">
                            <label for="new-pw">كلمة المرور الجديدة</label>
                            <div class="pw-wrap">
                                <input type="password" id="new-pw" autocomplete="new-password" placeholder="6 أحرف على الأقل" class="field-input"/>
                                <button type="button" class="pw-toggle" id="pw-t2" aria-label="إظهار">
                                    <i id="eye-t2" class="bi bi-eye"></i>
                                    <i id="eye-off-t2" class="bi bi-eye-slash" style="display:none;"></i>
                                </button>
                            </div>
                            <p id="pw-new-err" class="field-error" style="display:none;"></p>
                        </div>
                        <div class="field">
                            <label for="confirm-pw">تأكيد كلمة المرور</label>
                            <div class="pw-wrap">
                                <input type="password" id="confirm-pw" autocomplete="new-password" placeholder="أعد إدخال كلمة المرور" class="field-input"/>
                                <button type="button" class="pw-toggle" id="pw-t3" aria-label="إظهار">
                                    <i id="eye-t3" class="bi bi-eye"></i>
                                    <i id="eye-off-t3" class="bi bi-eye-slash" style="display:none;"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn-primary" id="reset-btn">
                            <span class="btn-spinner" id="reset-spin"></span>
                            <span class="btn-label">تأكيد وتسجيل الدخول</span>
                        </button>
                    </div>

                    {{-- ── STEP 3: نجاح ── --}}
                    <div id="rec-step-success" class="success-mini">
                        <div class="check-circle"><i class="bi bi-check-lg"></i></div>
                        <h3>تم تغيير كلمة المرور!</h3>
                        <p>جارٍ تحويلك للوحة التحكم...</p>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" id="success-bar"></div>
                        </div>
                    </div>

                </div>{{-- /recovery-inner --}}
            </div>{{-- /recovery-accordion --}}

            <div class="divider" style="margin-top:1.4rem;"></div>
            <p class="register-hint fade-up fu-d3">
                لا تملك حساباً؟ <a href="{{ url('/booking') }}">ابدأ مشروعك الآن</a>
            </p>
            <p class="form-note fade-up fu-d3">
                بعد الحجز يمكنك تعيين كلمة المرور من صفحة التأكيد<br>أو عبر الرابط الذي نرسله إليك.
            </p>

        </div>{{-- /form-inner --}}
    </div>{{-- /form-panel --}}

</div>{{-- /page --}}

<script>
(function () {
    'use strict';

    var meta = document.querySelector('meta[name="csrf-token"]');
    var CSRF = meta ? meta.getAttribute('content') : '';

    /* ── helpers ─────────────────────────────────────── */
    function postJson(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(data),
            credentials: 'same-origin',
        }).then(function (r) {
            return r.text().then(function (text) {
                var d = {};
                try { d = text ? JSON.parse(text) : {}; } catch (e) { d = { message: r.status === 419 ? 'انتهت الجلسة. حدّث الصفحة وحاول مجدداً.' : (r.status + ' ' + r.statusText) }; }
                return { ok: r.ok, status: r.status, data: d };
            });
        });
    }

    function showErr(wrapId, msg) {
        var w = document.getElementById(wrapId);
        if (w) w.innerHTML = '<div class="error-alert" role="alert"><p>' + msg + '</p></div>';
    }
    function clearErr(wrapId) {
        var w = document.getElementById(wrapId);
        if (w) w.innerHTML = '';
    }
    function showSuccess(wrapId, msg) {
        var w = document.getElementById(wrapId);
        if (w) w.innerHTML = '<div class="success-alert" role="alert">' + msg + '</div>';
    }

    function maskEmail(e) {
        var p = e.split('@');
        if (p.length !== 2) return e;
        var n = p[0];
        return n.slice(0, 2) + '***' + (n.slice(-1) || '') + '@' + p[1];
    }

    function pwToggle(btnId, inputEl, eyeId, eyeOffId) {
        var btn = document.getElementById(btnId);
        var eye = document.getElementById(eyeId);
        var eo  = document.getElementById(eyeOffId);
        if (!btn || !inputEl) return;
        btn.addEventListener('click', function () {
            var s = inputEl.type === 'password';
            inputEl.type    = s ? 'text' : 'password';
            eye.style.display = s ? 'none' : '';
            eo.style.display  = s ? '' : 'none';
            btn.setAttribute('aria-label', s ? 'إخفاء' : 'إظهار');
        });
    }
    pwToggle('pw-toggle', document.getElementById('pw-field'),   'eye-show', 'eye-hide');
    pwToggle('pw-t2',     document.getElementById('new-pw'),     'eye-t2',   'eye-off-t2');
    pwToggle('pw-t3',     document.getElementById('confirm-pw'), 'eye-t3',   'eye-off-t3');

    /* ── login submit ──────────────────────────────────── */
    var loginForm = document.getElementById('login-form');
    var loginBtn  = document.getElementById('login-btn');
    loginForm.addEventListener('submit', function () {
        loginBtn.disabled = true;
        loginBtn.classList.add('loading');
    });

    /* ════════════════════════════════════════════════════
       ACCORDION TOGGLE
    ════════════════════════════════════════════════════ */
    var trigger   = document.getElementById('forgot-trigger');
    var accordion = document.getElementById('recovery-accordion');
    var card      = document.getElementById('login-card');
    var isOpen    = false;

    function openAccordion() {
        isOpen = true;
        accordion.classList.add('open');
        card.classList.add('recovery-open');
        trigger.classList.add('open');
        trigger.setAttribute('aria-expanded', 'true');
        // scroll ناعم لتظهر الـ accordion بالكامل
        setTimeout(function () {
            accordion.scrollIntoView({ behavior: 'smooth', block: 'start' });
            window.scrollBy({ top: 200, behavior: 'smooth' });
            document.getElementById('rec-email').focus();
        }, 460);
    }

    function closeAccordion() {
        isOpen = false;
        accordion.classList.remove('open');
        card.classList.remove('recovery-open');
        trigger.classList.remove('open');
        trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', function () {
        isOpen ? closeAccordion() : openAccordion();
    });

    /* ── step management ─────────────────────────────── */
    var step1El = document.getElementById('rec-step-1');
    var step2Head = document.getElementById('rec-step-2-head');
    var otpBlockEl = document.getElementById('rec-otp-block');
    var pwBlockEl = document.getElementById('rec-password-block');
    var step3El = document.getElementById('rec-step-success');

    function goStep(n) {
        /* كل المحتوى ظاهر؛ نحدّث الحبوب والخطوة 3 فقط */
        if (step3El) step3El.style.display = n === 3 ? 'block' : 'none';

        var pills = ['pill-1','pill-2','pill-3'];
        pills.forEach(function (id, i) {
            var el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('active','done');
            if (i + 1 < n) el.classList.add('done');
            else if (i + 1 === n) el.classList.add('active');
        });

        setTimeout(function () {
            try { accordion.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); } catch (e) {}
            if (n === 2 && otpBlockEl) otpBlockEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }

    /* ── state ───────────────────────────────────────── */
    var currentEmail = '';
    var cdInterval   = null;
    var resendTimer  = null;

    /* ── SEND OTP ─────────────────────────────────────── */
    document.getElementById('send-otp-btn').addEventListener('click', function () {
        var email = document.getElementById('rec-email').value.trim();
        var emailErr = document.getElementById('rec-email-err');
        emailErr.style.display = 'none';
        clearErr('rec-error-1');

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            emailErr.textContent = 'أدخل بريدًا إلكترونيًا صحيحًا.';
            emailErr.style.display = 'block';
            return;
        }

        var btn = this;
        btn.disabled = true;
        btn.classList.add('loading');

        postJson('{{ route("client.forgot-password.send") }}', { email: email })
            .then(function (res) {
                btn.disabled = false;
                btn.classList.remove('loading');

                if (res.ok && res.data.success) {
                    currentEmail = email;
                    var otpSentTo = document.getElementById('otp-sent-to');
                    if (otpSentTo) otpSentTo.textContent = maskEmail(email);
                    goStep(2);
                    startCountdown();
                    startResendTimer();
                    var firstOtp = document.querySelector('.otp-box');
                    setTimeout(function () {
                        if (firstOtp) { firstOtp.focus(); firstOtp.value = ''; }
                        try { if (otpBlockEl) otpBlockEl.scrollIntoView({ behavior: 'smooth', block: 'center' }); } catch (e) {}
                    }, 200);
                } else {
                    var msg = res.data.errors && res.data.errors.email
                        ? res.data.errors.email[0]
                        : (res.data.message || (res.status === 419 ? 'انتهت الجلسة. حدّث الصفحة (F5) وحاول مجدداً.' : (res.status === 500 ? 'خطأ من الخادم. تأكد من تشغيل php artisan migrate (جدول client_password_otps).' : 'حدث خطأ. حاول مجدداً.')));
                    showErr('rec-error-1', msg);
                }
            })
            .catch(function (err) {
                btn.disabled = false;
                btn.classList.remove('loading');
                showErr('rec-error-1', 'تعذّر الاتصال بالخادم. تحقق من تشغيل الموقع (php artisan serve) وأن الرابط صحيح.');
            });
    });

    var otpVerified = false;
    var verifyInProgress = false;

    function showPasswordSection() {
        otpVerified = true;
        var np = document.getElementById('new-pw');
        if (np) setTimeout(function () { np.focus(); }, 100);
        setTimeout(function () { try { if (pwBlockEl) pwBlockEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); } catch (e) {} }, 80);
    }
    function hidePasswordSection() {
        otpVerified = false;
        var np = document.getElementById('new-pw');
        var cp = document.getElementById('confirm-pw');
        if (np) np.value = '';
        if (cp) cp.value = '';
    }

    document.getElementById('back-to-step1').addEventListener('click', function () {
        if (cdInterval) clearInterval(cdInterval);
        if (resendTimer) clearInterval(resendTimer);
        clearErr('rec-error-2');
        clearErr('rec-error-1');
        hidePasswordSection();
        document.querySelectorAll('.otp-box').forEach(function (b) { b.value=''; b.classList.remove('err'); });
        goStep(1);
        setTimeout(function () { document.getElementById('rec-email').focus(); }, 50);
    });

    /* ── التحقق من الكود عند إكمال 6 أرقام ───────────────── */
    function checkOtpAndVerify() {
        var code = getOtp();
        if (code.length !== 6 || otpVerified || verifyInProgress) return;
        verifyInProgress = true;
        clearErr('rec-error-2');
        postJson('{{ route("client.forgot-password.verify") }}', { code: code })
            .then(function (res) {
                verifyInProgress = false;
                if (res.ok && res.data.success) {
                    showPasswordSection();
                    document.getElementById('new-pw').focus();
                } else {
                    var msg = (res.data.errors && res.data.errors.code) ? res.data.errors.code[0] : (res.data.message || 'الكود غير صحيح.');
                    showErr('rec-error-2', msg);
                    otpBoxes.forEach(function (b) { b.value = ''; b.classList.add('err'); });
                    otpBoxes[0].focus();
                }
            })
            .catch(function () {
                verifyInProgress = false;
                showErr('rec-error-2', 'تعذّر التحقق. حاول مجدداً.');
                otpBoxes.forEach(function (b) { b.classList.add('err'); });
            });
    }

    /* ── OTP digit inputs ─────────────────────────────── */
    var otpBoxes = document.querySelectorAll('.otp-box');
    otpBoxes.forEach(function (inp, idx) {
        inp.addEventListener('input', function () {
            inp.value = inp.value.replace(/\D/, '').slice(-1);
            inp.classList.remove('err');
            if (inp.value && idx < 5) otpBoxes[idx + 1].focus();
            if (getOtp().length === 6) setTimeout(checkOtpAndVerify, 80);
            else hidePasswordSection();
        });
        inp.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !inp.value && idx > 0) {
                otpBoxes[idx - 1].focus();
                otpBoxes[idx - 1].value = '';
                hidePasswordSection();
            }
        });
        inp.addEventListener('paste', function (e) {
            e.preventDefault();
            var p = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            p.split('').forEach(function (c, i) { if (otpBoxes[i]) otpBoxes[i].value = c; });
            otpBoxes[Math.min(p.length, 5)].focus();
            if (getOtp().length === 6) setTimeout(checkOtpAndVerify, 120);
        });
    });

    function getOtp() { return Array.from(otpBoxes).map(function (b) { return b.value; }).join(''); }

    /* ── countdown ────────────────────────────────────── */
    function startCountdown() {
        if (cdInterval) clearInterval(cdInterval);
        var s = 600;
        var el = document.getElementById('countdown');
        el.style.color = '';
        cdInterval = setInterval(function () {
            s--;
            if (s <= 0) { clearInterval(cdInterval); el.textContent = 'منتهي'; el.style.color = '#f87171'; return; }
            var m = Math.floor(s / 60), sec = s % 60;
            el.textContent = (m < 10 ? '0' : '') + m + ':' + (sec < 10 ? '0' : '') + sec;
        }, 1000);
    }

    function startResendTimer() {
        if (resendTimer) clearInterval(resendTimer);
        var s = 120;
        var btn = document.getElementById('resend-btn');
        var cd  = document.getElementById('resend-cd');
        var lbl = document.getElementById('resend-sec');
        btn.disabled = true;
        cd.style.display = 'inline';
        lbl.textContent = s;
        resendTimer = setInterval(function () {
            s--;
            lbl.textContent = s;
            if (s <= 0) { clearInterval(resendTimer); btn.disabled = false; cd.style.display = 'none'; }
        }, 1000);
    }

    /* ── RESEND ───────────────────────────────────────── */
    document.getElementById('resend-btn').addEventListener('click', function () {
        clearErr('rec-error-2');
        hidePasswordSection();
        postJson('{{ route("client.forgot-password.resend") }}', { email: currentEmail })
            .then(function (res) {
                otpBoxes.forEach(function (b) { b.value = ''; b.classList.remove('err'); });
                otpBoxes[0].focus();
                startCountdown();
                startResendTimer();
                showSuccess('rec-error-2', 'تم إعادة إرسال الكود.');
            })
            .catch(function () { showErr('rec-error-2', 'تعذّر إعادة الإرسال.'); });
    });

    /* ── RESET PASSWORD ───────────────────────────────── */
    document.getElementById('reset-btn').addEventListener('click', function () {
        clearErr('rec-error-2');
        var pwErr = document.getElementById('pw-new-err');
        pwErr.style.display = 'none';

        var code     = getOtp();
        var password = document.getElementById('new-pw').value;
        var confirm  = document.getElementById('confirm-pw').value;

        if (code.length !== 6) {
            otpBoxes.forEach(function (b) { if (!b.value) b.classList.add('err'); });
            showErr('rec-error-2', 'أدخل الكود المكوّن من 6 أرقام.');
            otpBoxes[0].focus();
            return;
        }
        if (password.length < 6) {
            pwErr.textContent = 'كلمة المرور يجب أن لا تقل عن 6 أحرف.';
            pwErr.style.display = 'block';
            document.getElementById('new-pw').focus();
            return;
        }
        if (password !== confirm) {
            pwErr.textContent = 'كلمة المرور وتأكيدها غير متطابقتان.';
            pwErr.style.display = 'block';
            return;
        }

        var btn = this;
        btn.disabled = true;
        btn.classList.add('loading');

        postJson('{{ route("client.forgot-password.reset") }}', {
            code: code,
            password: password,
            password_confirmation: confirm,
        })
        .then(function (res) {
            btn.disabled = false;
            btn.classList.remove('loading');

            if (res.ok && res.data.success) {
                if (cdInterval) clearInterval(cdInterval);
                if (resendTimer) clearInterval(resendTimer);
                goStep(3);
                // expand accordion لتظهر شاشة النجاح
                accordion.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(function () {
                    document.getElementById('success-bar').style.width = '100%';
                }, 80);
                setTimeout(function () {
                    window.location.href = res.data.redirect || '{{ route("client.dashboard") }}';
                }, 2300);
            } else {
                var msg = (res.data.errors && res.data.errors.code)
                    ? res.data.errors.code[0]
                    : (res.data.errors && res.data.errors.password)
                        ? res.data.errors.password[0]
                        : (res.data.message || 'حدث خطأ. حاول مجدداً.');
                showErr('rec-error-2', msg);
                hidePasswordSection();
                otpBoxes.forEach(function (b) { b.value = ''; b.classList.remove('err'); });
                otpBoxes[0].focus();
            }
        })
        .catch(function () {
            btn.disabled = false;
            btn.classList.remove('loading');
            showErr('rec-error-2', 'تعذّر الاتصال بالخادم.');
        });
    });

    /* ── auto-open if came from ?forgot=1 ─────────────── */
    if (new URLSearchParams(window.location.search).get('forgot') === '1') {
        openAccordion();
    }

})();
</script>
</body>
</html>