<?php

declare(strict_types=1);

namespace App\Teapot\Exception;

use App\Teapot\View\Refuse;
use Symfony\Component\HttpFoundation\Response;
use Violines\RestBundle\Error\ErrorInterface;

final class RefuseToBrew extends \RuntimeException implements ErrorInterface
{
    public static function coffee()
    {
        return new static('Refuse to brew coffee because I\'m a teapot, permanently.');
    }

    public function getContent(): object
    {
        return Refuse::fromException($this);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_I_AM_A_TEAPOT;
    }
}
