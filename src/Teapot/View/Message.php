<?php

declare(strict_types=1);

namespace App\Teapot\View;

use Violines\RestBundle\HttpApi\HttpApi;

/**
 * @HttpApi
 */
final class Message
{
    public $message;

    private function __construct(string $message)
    {
        $this->message = $message;
    }

    public static function hello(): self
    {
        return new static("I can brew tea");
    }
}
