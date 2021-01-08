<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\CreateDrink;
use Symfony\Component\HttpFoundation\JsonResponse;
use function React\Promise\resolve;

class Teapot
{
    private const COFFEE = 'coffee';
    private const TEA = 'tea';

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

        return resolve(new JsonResponse(['message' => "Enjoy your $amountOfCups cups of tea."], 200));
    }
}
