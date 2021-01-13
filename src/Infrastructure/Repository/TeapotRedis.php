<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Teapot\Repository\TeapotRepository;
use Clue\React\Redis\Client;
use React\Promise\PromiseInterface;

final class TeapotRedis implements TeapotRepository
{
    private const AMOUNT_KEY = 'amount_of_drinks';
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @psalm-suppress InvalidScalarArgument
     */
    public function addToTotalServedCups(int $amount): PromiseInterface
    {
        return $this->client->incrby(self::AMOUNT_KEY, $amount);
    }

    public function findTotalServedCups(): PromiseInterface
    {
        return $this->client->get(self::AMOUNT_KEY);
    }
}
