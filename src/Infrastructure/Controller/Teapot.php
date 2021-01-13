<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Response\ResponseHandler;
use App\Teapot\Command\CreateBeverages;
use App\Teapot\TeapotAppService;
use App\Teapot\View\Refuse;
use App\Teapot\View\TeapotStatus;
use Symfony\Component\HttpFoundation\JsonResponse;

use function React\Promise\resolve;

class Teapot
{
    private ResponseHandler $responseHandler;
    private TeapotAppService $teapotAppService;

    public function __construct(ResponseHandler $responseHandler, TeapotAppService $teapotAppService)
    {
        $this->responseHandler = $responseHandler;
        $this->teapotAppService = $teapotAppService;
    }

    public function hello()
    {
        return resolve(new JsonResponse(['I can brew' => 'tea'], 200));
    }

    public function brew(CreateBeverages $createBeverages)
    {
        return $this->teapotAppService->brew($createBeverages)->then(
            fn ($total) => $this->responseHandler->createResponse(TeapotStatus::current($createBeverages->amountOfCups, (int)$total)),
            fn ($e) => $this->responseHandler->createResponse(Refuse::fromException($e), 418)
        );
    }
}
