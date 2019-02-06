<?php

namespace App\Controller\Api;

use App\Response\ApiResponse;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    public function createJsonResponse(ApiResponse $apiResponse, $groups = ['Default'])
    {
        if ($apiResponse->getStatus() === ApiResponse::STATUS_SUCCESS && is_null($apiResponse->getMessage())) {
            $apiResponse->setMessage('İşlem Başarılı.');
        }

        $serializationContext = SerializationContext::create()->setSerializeNull(true)->setGroups($groups);

        $serializer = SerializerBuilder::create()->build();

        $content = $serializer->serialize($apiResponse->toAssocArray(), 'json', $serializationContext);

        return new Response($content, $apiResponse->getCode(), ['Content-Type' => 'application/json']);
    }
}