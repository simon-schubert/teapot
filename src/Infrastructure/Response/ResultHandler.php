<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Violines\RestBundle\Negotiation\ContentNegotiator;
use Violines\RestBundle\Request\AcceptHeader;
use Violines\RestBundle\Response\ContentTypeHeader;
use Violines\RestBundle\Response\ResponseBuilder;
use Violines\RestBundle\Serialize\Serializer;

final class ResultHandler
{
    private ContentNegotiator $contentNegotiator;
    private ResponseBuilder $responseBuilder;
    private Serializer $serializer;

    public function __construct(
        ContentNegotiator $contentNegotiator,
        ResponseBuilder $responseBuilder,
        Serializer $serializer
    ) {
        $this->contentNegotiator = $contentNegotiator;
        $this->responseBuilder = $responseBuilder;
        $this->serializer = $serializer;
    }
    /**
     * @param object[]|object $data
     */
    public function handle($data, Request $request): Response
    {
        $acceptHeader = AcceptHeader::fromString((string) $request->headers->get(AcceptHeader::NAME, ''));
        $preferredMimeType = $this->contentNegotiator->negotiate($acceptHeader);

        return $this->responseBuilder
            ->setContent($this->serializer->serialize($data, $preferredMimeType))
            ->setContentType(ContentTypeHeader::fromString($preferredMimeType->toString()))
            ->getResponse();
    }
}
