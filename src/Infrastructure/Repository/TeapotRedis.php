<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Clue\React\Redis\Client;
use React\Promise\PromiseInterface;

class TeapotRedis
{
    private const AMOUNT_KEY = 'amount_of_drinks';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function addAmountOfDrinks(int $amount): PromiseInterface
    {
        return $this->client->incrby(self::AMOUNT_KEY, $amount);
    }

    public function findAmountOfDrinks(): PromiseInterface
    {
        return $this->client->get(self::AMOUNT_KEY);
    }
}
