<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Teapot\Command\CreateBeverages;
use App\Teapot\TeapotAppService;
use App\Teapot\View\Refuse;
use App\Teapot\View\TeapotStatus;
use Symfony\Component\HttpFoundation\JsonResponse;
use function React\Promise\resolve;

class Teapot
{
    private TeapotAppService $teapotAppService;

    public function __construct(TeapotAppService $teapotAppService)
    {
        $this->teapotAppService = $teapotAppService;
    }

    public function hello()
    {
        return resolve(new JsonResponse(['I can brew' => 'tea'], 200));
    }

    public function brew(CreateBeverages $createBeverages)
    {
        return $this->teapotAppService->brew($createBeverages)
            ->then(
                fn ($total) => new JsonResponse(TeapotStatus::current($createBeverages->amountOfCups, (int)$total), 200),
                fn ($e) => new JsonResponse(Refuse::fromException($e), 418)
            );
    }
}
