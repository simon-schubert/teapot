<?php

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Violines\RestBundle\Negotiation\ContentNegotiator;
use Violines\RestBundle\Request\AcceptHeader;
use Violines\RestBundle\Response\ContentTypeHeader;
use Violines\RestBundle\Response\ResponseBuilder;
use Violines\RestBundle\Serialize\Serializer;

final class ResponseHandler
{
    private ContentNegotiator $contentNegotiator;
    private RequestStack $requestStack;
    private ResponseBuilder $responseBuilder;
    private Serializer $serializer;

    public function __construct(
        ContentNegotiator $contentNegotiator,
        RequestStack $requestStack,
        ResponseBuilder $responseBuilder,
        Serializer $serializer
    ) {
        $this->contentNegotiator = $contentNegotiator;
        $this->requestStack = $requestStack;
        $this->responseBuilder = $responseBuilder;
        $this->serializer = $serializer;
    }
    /**
     * @param object[]|object $data
     */
    public function createResponse($data, int $status = Response::HTTP_OK): Response
    {
        $acceptHeader = AcceptHeader::fromString('application/json');
        $preferredMimeType = $this->contentNegotiator->negotiate($acceptHeader);

        return $this->responseBuilder
            ->setContent($this->serializer->serialize($data, $preferredMimeType))
            ->setContentType(ContentTypeHeader::fromString($preferredMimeType->toString()))
            ->setStatus($status)
            ->getResponse();
    }
}
