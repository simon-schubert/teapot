<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Repository\TeapotRedis;
use App\Teapot\Command\CreateDrink;
use App\Teapot\View\TeapotStatus;
use Symfony\Component\HttpFoundation\JsonResponse;
use function React\Promise\resolve;

class Teapot
{
    private const COFFEE = 'coffee';
    private const TEA = 'tea';
    private TeapotRedis $teapotRepository;

    public function __construct(TeapotRedis $teapotRepository)
    {
        $this->teapotRepository = $teapotRepository;
    }

    public function hello()
    {
        return resolve(new JsonResponse(['I can brew' => 'tea'], 200));
    }

    public function brew(CreateDrink $createDrink)
    {
        if (self::COFFEE === $createDrink->type) {
            return resolve(new JsonResponse(['I am' => 'a teapot'], 418));
        }

        $amountOfCups = 0;
        if (self::TEA === $createDrink->type) {
            $amountOfCups = $createDrink->amountOfCups;
        }

        return $this->teapotRepository
            ->addAmountOfDrinks($amountOfCups)
            ->then(fn () => $this->teapotRepository->findAmountOfDrinks())
            ->then(fn ($total) => new JsonResponse(TeapotStatus::current($amountOfCups, (int)$total), 200));
    }
}
