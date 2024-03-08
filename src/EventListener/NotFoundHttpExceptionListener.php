<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class NotFoundHttpExceptionListener
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // $exception = $event->getThrowable();
        // if ($exception instanceof NotFoundHttpException) {
        //     $response = new RedirectResponse($this->router->generate('app_home'));
        //     $event->setResponse($response);
        // }
    }
}
