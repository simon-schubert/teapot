<?php

declare(strict_types=1);

namespace App\Teapot\View;

use Violines\RestBundle\HttpApi\HttpApi;

/**
 * @HttpApi
 */
final class TeapotStatus
{
    public $servedCups;

    public $totalServedCups;

    private function __construct(int $served, int $total)
    {
        $this->servedCups = $served;
        $this->totalServedCups = $total;
    }

    public static function current(int $served, int $total): self
    {
        return new static($served, $total);
    }
}
