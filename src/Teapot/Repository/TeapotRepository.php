<?php

namespace App\Teapot\Repository;

use React\Promise\PromiseInterface;

interface TeapotRepository
{
    public function addToTotalServedCups(int $amount): PromiseInterface;

    public function findTotalServedCups(): PromiseInterface;
}
