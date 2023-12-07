<?php

namespace App\EventListener;

use App\Exceptions\CustomException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

#[AsEventListener]
class ApiExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = sprintf(
            'Message: %s',
            $exception->getMessage()
        );
        $data = $exception instanceof CustomException && $exception->getCustomData() !== null ? $exception->getCustomData() : [];
        $statusCode = !is_null($exception->getCode()) && $exception->getCode() >= 400 ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof \SoapFault) {
            $data = !is_null($exception->detail) && is_object($exception->detail) ?
                $exception->detail :
                $exception->faultstring;
            $statusCode = 422;
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        $response = new JsonResponse([
            'error' => $message,
            'data' => $data
        ], $statusCode);
        $event->setResponse($response);
    }

}
