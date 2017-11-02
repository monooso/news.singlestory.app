<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = ['password', 'password_confirmation'];

    /**
     * Report or log an exception. This is a great spot to send exceptions to
     * Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     */
    public function report(Exception $exception)
    {
        if ($this->shouldReportToSentry($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Returns a boolean indicating whether we should report the given error to
     * Sentry.
     *
     * @param Exception $exception
     *
     * @return bool
     */
    protected function shouldReportToSentry(Exception $exception): bool
    {
        return !app()->isLocal()
            && app()->bound('sentry')
            && $this->shouldReport($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Exception                $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof InvalidTokenException) {
            return abort(404, $exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
