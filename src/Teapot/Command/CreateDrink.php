<?php

declare(strict_types=1);

namespace App\Teapot\Command;

use Violines\RestBundle\HttpApi\HttpApi;

/**
 * @HttpApi
 */
final class CreateDrink
{
    public $type;

    public $amountOfCups;
}
