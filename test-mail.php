<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    \Illuminate\Support\Facades\Mail::raw('Test ONX - البريد يعمل!', function ($message) {
        $message->to('hamzaouisalah29@gmail.com')->subject('Test Email - ONX');
    });
    echo "✅ تم الإرسال بنجاح!\n";
} catch (\Exception $e) {
    echo "❌ خطأ: " . $e->getMessage() . "\n";
}
