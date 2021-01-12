<?php

declare(strict_types=1);

namespace App\Teapot\Exception;

final class RefuseToBrew extends \RuntimeException
{
    public static function coffee()
    {
        return new static('Refuse to brew coffee because I\'m a teapot, permanently.');
    }
}
