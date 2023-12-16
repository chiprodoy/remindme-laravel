<?php

namespace App\Exceptions;

use App\Enum\HttpStatus;
use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\FailMessage;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // by type hinting ValidationException here this handler
        // will only be executed for this Exception class
        $this->renderable(function (ValidationException $exception, $request) {
            if (! $request->wantsJson()) {
                // tell Laravel to handle as usual
                return null;
            }

            $msg=new FailMessage('ERR_BAD_REQUEST',$exception->validator->errors()->all());

            return $this->showResponseOnJSONFormat(false,$msg,HttpStatus::VALIDATIONERROR);
        });
    }
}
