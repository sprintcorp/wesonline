<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //Handle Validation exceptions
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }

        //Handle Authentication exception
        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }
        
        if($exception instanceof TokenInvalidException){
            return response()->json(['error' =>'Token is invalid'],400);
        }
        if($exception instanceof TokenExpiredException){
            return response()->json(['error' =>'Token expired'],404);
        }
        if($exception instanceof JWTException){
            return response()->json(['error' =>'There is a problem with your token'],404);
        }
        if($exception instanceof QueryException){
            return response()->json(['error' =>$exception->getMessage()],500);
        }
        if($exception instanceof RouteNotFoundException){
            return response()->json(['error' =>$exception->getMessage()],404);
        }
        if($exception instanceof MethodNotAllowedHttpException){
            return response()->json(['error' => $exception->getMessage()],405);
        }
        //Handle NotFoundHTTP exception
        if($exception instanceof NotFoundHttpException){
            return response()->json(['error' =>'The specified URL cannot be found'],404);
        }
        if($exception instanceof HttpException){
            return response()->json(['error' =>'Unauthorized action'],422);
        }

        //Handle model exceptions
        if($exception instanceof ModelNotFoundException){
            $modelName = strtolower(class_basename($exception->getModel()));
            return response()->json(['error' => "No {$modelName} exist with this Identifier"],404);
        }
        return parent::render($request, $exception);
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'unauthenticated '.$exception->getLine()],401);
    }
    
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();
            return response()->json(['error'=>$errors],422);
    }
}
