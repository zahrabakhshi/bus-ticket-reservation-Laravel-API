<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Nette\Schema\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
//    public function register()
//    {
//        $this->reportable(function (ValidationException $e) {
//            //
//        });
//        $this->renderable(function (ValidationException $e){
//            return response()->json([
//                'message' => $e->getMessages(),
//                'status' => Response::HTTP_UNPROCESSABLE_ENTITY
//            ]);
//        });
//        $this->reportable(function (Throwable $e) {
//            //
//        });
//        $this->renderable(function (Throwable $e){
//            return response()->json([
////                'message' => 'cause server error',
//                'message' => $e->getMessage(),
//                'line' => $e->getLine(),
//                'file' => $e->getTrace(),
//                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
//            ]);
//        });
//    }
}
