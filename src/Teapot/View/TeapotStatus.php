<?php

declare(strict_types=1);

namespace App\Teapot\View;

final class TeapotStatus
{
    public $servedCups;

    public $totalProducedCups;

    private function __construct(int $served, int $total)
    {
        $this->servedCups = $served;
        $this->totalProducedCups = $total;
    }

    public static function current(int $served, int $total): self
    {
        return new static($served, $total);
    }
}
