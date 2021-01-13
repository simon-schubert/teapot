<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Response\ErrorHandler;
use App\Infrastructure\Response\ResultHandler;
use App\Teapot\Command\CreateBeverages;
use App\Teapot\TeapotAppService;
use App\Teapot\View\Message;
use App\Teapot\View\TeapotStatus;
use Symfony\Component\HttpFoundation\Request;
use Violines\RestBundle\Error\ErrorInterface;

use function React\Promise\resolve;

final class Teapot
{
    private ErrorHandler $errorHandler;
    private ResultHandler $resultHandler;
    private TeapotAppService $teapotAppService;

    public function __construct(ErrorHandler $errorHandler, ResultHandler $resultHandler, TeapotAppService $teapotAppService)
    {
        $this->errorHandler = $errorHandler;
        $this->resultHandler = $resultHandler;
        $this->teapotAppService = $teapotAppService;
    }

    public function hello(Request $request)
    {
        return resolve($this->resultHandler->handle(Message::hello(), $request));
    }

    public function brew(CreateBeverages $createBeverages, Request $request)
    {
        return $this->teapotAppService->brew($createBeverages)->then(
            fn (TeapotStatus $status) => $this->resultHandler->handle($status, $request),
            fn (ErrorInterface $e) => $this->errorHandler->handle($e, $request)
        );
    }
}
