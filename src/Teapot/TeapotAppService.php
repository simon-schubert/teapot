<?php

declare(strict_types=1);

namespace App\Teapot;

use App\Teapot\Command\CreateBeverages;
use App\Teapot\Exception\RefuseToBrew;
use App\Teapot\Repository\TeapotRepository;
use React\Promise\PromiseInterface;

use function React\Promise\reject;

final class TeapotAppService
{
    private const COFFEE = 'coffee';
    private const TEA = 'tea';
    private TeapotRepository $teapotRepository;

    public function __construct(TeapotRepository $teapotRepository)
    {
        $this->teapotRepository = $teapotRepository;
    }

    public function brew(CreateBeverages $createBeverages): PromiseInterface
    {
        if (self::COFFEE === $createBeverages->type) {
            return reject(RefuseToBrew::coffee());
        }

        $amountOfCups = 0;
        if (self::TEA === $createBeverages->type) {
            $amountOfCups = $createBeverages->amountOfCups;
        }

        return $this->teapotRepository
            ->addToTotalServedCups($amountOfCups)
            ->then(fn () => $this->teapotRepository->findTotalServedCups());
    }
}
