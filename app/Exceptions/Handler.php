<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'تم إرسال عدد كبير من الطلبات. يرجى الانتظار دقيقة ثم المحاولة مرة أخرى.',
                ], 429);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'throttle' => 'تم إرسال عدد كبير من الطلبات. يرجى الانتظار دقيقة ثم المحاولة مرة أخرى.',
                ]);
        });

        $this->renderable(function (PostTooLargeException $e, $request) {
            $message = 'حجم الملفات أو البيانات المرسلة أكبر من المسموح. قلّل حجم الصور أو عددها، أو راجع إعدادات الخادم (post_max_size و upload_max_filesize في php.ini).';
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }
            return redirect()->back()->withErrors(['post_size' => $message]);
        });
    }
}