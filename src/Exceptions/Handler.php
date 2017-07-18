<?php

namespace Sco\Admin\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Sco\Admin\Contracts\ExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler implements ExceptionHandlerContract
{
    protected $parentHandler;

    public function __construct(ExceptionHandlerContract $parentHandler)
    {
        $this->parentHandler = $parentHandler;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     *
     * @return void
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        $this->parentHandler->report($exception);
    }

    /**
     * Render an exception into a response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof AuthenticationException) {
            $response = $this->unauthenticated($request, $exception);
        } elseif ($exception instanceof HttpException) {
            $response = $this->renderHttpException($request, $exception);
        } elseif ($exception instanceof ExceptionInterface) {
            $response = $this->renderAdminException($request, $exception);
        }

        if (isset($response)) {
            return $response;
        }

        return $this->parentHandler->render($request, $exception);
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception                                        $exception
     *
     * @return void
     */
    public function renderForConsole($output, Exception $exception)
    {
        $this->parentHandler->renderForConsole($output, $exception);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Exception $exception
     *
     * @return \Exception
     */
    protected function prepareException(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException(
                $exception->getMessage(),
                $exception
            );
        } elseif ($exception instanceof AuthorizationException) {
            $exception = new HttpException(
                403,
                $exception->getMessage() ?: Response::$statusTexts[403]
            );
        }

        return $exception;
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated(
        $request,
        AuthenticationException $exception
    ) {
        if ($request->expectsJson()) {
            return response('Unauthenticated', 401);
        }

        if ($this->isAdmin($request)) {
            return redirect()->guest(route('admin.login'));
        }
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Illuminate\Http\Request                              $request
     * @param  \Symfony\Component\HttpKernel\Exception\HttpException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException($request, HttpException $exception)
    {
        $status = $exception->getStatusCode();
        if ($request->expectsJson()) {
            return response(
                $exception->getMessage() ?: Response::$statusTexts[$status],
                $status
            );
        }
        if ($this->isAdmin($request)) {
            //return response()->view('admin::app', ['exception' => $exception], $status, $exception->getHeaders());
        }
    }

    protected function isAdmin($request)
    {
        $route = $request->route();
        return $route && strpos($route->getPrefix(), config('admin.url_prefix')) === 0;
    }

    /**
     * @param \Illuminate\Http\Request                $request
     * @param \Sco\Admin\Contracts\ExceptionInterface $exception
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    protected function renderAdminException(
        $request, ExceptionInterface $exception
    ) {
        if ($request->expectsJson()) {
            return response(
                $exception->getMessage() ?: Response::$statusTexts[500],
                500
            );
        }
    }
}
