<?php

namespace App\Exceptions;

use Mail;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use App\Mail\ExceptionOccured;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        $request = request();
        if ($this->shouldReport($exception) && env('APP_ENV') == 'production') 
        {
            $this->sendEmail($exception, $request); // sends an email
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $json = [
            'success' => false,
            'error' => [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ],
        ];

       // return response()->json($json, 400);
    

        return parent::render($request, $exception);
    }

    /**
    * Send the exception to the specified email.
    *
    * @param \Exception $exception
    * @param \Illuminate\Http\Request $request
    * @return void
    */
    public function sendEmail(Exception $exception, $request)
    {
        // sending email
        try {
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = "<h2>An error occured while processing the request:</h2>";
            $html .= "<br/><p>URL: ".URL::current()."</p>";
            $html .= "<p>PARAMS: ".var_export($request->all(), true)."</p>";
            $html .= "<br/><h3>See Stacktrace Below:</h3><hr/>";
            $html .= $handler->getHtml($e);
            Mail::to(getenv('ADMIN_EMAIL'))->cc(getenv('DEV_EMAIL'))->send(new ExceptionOccured($html));
            Log::info("Exception sent!");
        } catch (Exception $ex) {
            Log::critical("Failed to send Exception Email");
        }
    }
}
