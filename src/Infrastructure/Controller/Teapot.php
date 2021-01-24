<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Teapot\Command\CreateBeverages;
use App\Teapot\TeapotAppService;
use App\Teapot\View\Message;
use App\Teapot\View\TeapotStatus;
use Symfony\Component\HttpFoundation\Request;
use Violines\RestBundle\Error\ErrorInterface;
use Violines\RestBundle\Response\ErrorResponseResolver;
use Violines\RestBundle\Response\SuccessResponseResolver;

use function React\Promise\resolve;

final class Teapot
{
    private ErrorResponseResolver $errorResponseResolver;
    private SuccessResponseResolver $successResponseResolver;
    private TeapotAppService $teapotAppService;

    public function __construct(ErrorResponseResolver $errorResponseResolver, SuccessResponseResolver $successResponseResolver, TeapotAppService $teapotAppService)
    {
        $this->errorResponseResolver = $errorResponseResolver;
        $this->successResponseResolver = $successResponseResolver;
        $this->teapotAppService = $teapotAppService;
    }

    public function hello(Request $request)
    {
        return resolve($this->successResponseResolver->resolve(Message::hello(), $request));
    }

    public function brew(CreateBeverages $createBeverages, Request $request)
    {
        return $this->teapotAppService->brew($createBeverages)
            ->then(fn (TeapotStatus $status) => $this->successResponseResolver->resolve($status, $request))
            ->otherwise(fn (ErrorInterface $e) => $this->errorResponseResolver->resolve($e, $request));
    }
}
