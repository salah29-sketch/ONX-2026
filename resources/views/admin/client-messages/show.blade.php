@extends('layouts.admin')

@section('content')
<div class="db-page-head">
    <div>
        <h1 class="db-page-title">رسالة من العميل</h1>
        <div class="db-page-subtitle">
            @if($message->client)
                <a href="{{ route('admin.clients.show', $message->client->id) }}">{{ $message->client->name }}</a>
                · {{ $message->created_at->format('Y-m-d H:i') }}
            @else
                {{ $message->created_at->format('Y-m-d H:i') }}
            @endif
        </div>
    </div>
    <a href="{{ route('admin.client-messages.index') }}" class="db-btn-secondary">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>
</div>

@if(session('message'))
    <div class="alert alert-success db-alert">{{ session('message') }}</div>
@endif

<div class="card db-card mb-4">
    <div class="card-body db-card-body">
        @if($message->subject)
            <p class="mb-2"><strong>الموضوع:</strong> {{ $message->subject }}</p>
        @endif
        <div class="border rounded p-3 bg-light mb-0">{{ nl2br(e($message->message)) }}</div>
    </div>
</div>

<div class="card db-card">
    <div class="db-card-header">
        <i class="fas fa-reply mr-2"></i>
        كتابة رد (قوالب سريعة)
    </div>
    <div class="card-body db-card-body">
        <div class="mb-3">
            <label class="form-label">إدراج قالب</label>
            <select id="replyTemplate" class="form-select">
                <option value="">— اختر قالباً —</option>
                <option value="تم استلام رسالتك، سنرد عليك بالتفاصيل قريباً. شكراً لتواصلك معنا.">تم استلام الرسالة / سنرد قريباً</option>
                <option value="نحتاج لمزيد من التفاصيل حول طلبك. يرجى توضيح [الموضوع] وسنكمل المعالجة.">نحتاج لمزيد من التفاصيل</option>
                <option value="تمت معالجة طلبك. في حال وجود أي استفسار نحن هنا لمساعدتك.">تمت المعالجة</option>
                <option value="نشكرك على تواصلك. نؤكد استلام رسالتك وسيتم الرد خلال 24 ساعة عمل.">تأكيد الاستلام + 24 ساعة</option>
                <option value="نعتذر عن التأخير. نعمل على طلبك وسنخبرك فور الانتهاء.">اعتذار عن التأخير</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">نص الرد</label>
            <textarea id="replyBody" class="form-control" rows="6" placeholder="اكتب ردك هنا أو اختر قالباً أعلاه..."></textarea>
        </div>
        <p class="text-muted small mb-0">يمكنك نسخ الرد وإرساله للعميل عبر البريد أو الواتساب. (إرسال تلقائي من النظام يمكن إضافته لاحقاً)</p>
    </div>
</div>

<script>
document.getElementById('replyTemplate').addEventListener('change', function() {
    var body = document.getElementById('replyBody');
    var v = this.value;
    if (v) {
        body.value = body.value ? body.value + '\n\n' + v : v;
        this.selectedIndex = 0;
    }
});
</script>
@endsection
