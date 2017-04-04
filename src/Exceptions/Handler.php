<?php

namespace Sco\Admin\Exceptions;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;

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
        if ($exception instanceof AdminHttpException) {
            return response($exception->getMessage(), $exception->getStatusCode());
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
}
