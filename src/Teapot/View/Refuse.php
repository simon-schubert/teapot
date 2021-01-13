<?php

declare(strict_types=1);

namespace App\Teapot\View;

use App\Teapot\Exception\RefuseToBrew;
use Violines\RestBundle\HttpApi\HttpApi;

/**
 * @HttpApi
 */
final class Refuse
{
    public $message;

    private function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function fromException(RefuseToBrew $refuseToBrew): self
    {
        return new static($refuseToBrew->getMessage());
    }
}
