<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\Response\ApiResponse;

class KernelListener
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

     /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        ContainerInterface $container
    ) {
        $this->em = $em;
        $this->serializer = $serializer;
        $this->container = $container;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($this->em->getConnection()->isTransactionActive()) {
            $this->em->rollback();
        }

        // You get the exception object from the received event
        $exception = $event->getException();
        
        $debug = $this->container->get('kernel')->getEnvironment();

        $stackTraceErrors = $this->formatStackTraceErrors($exception->getTrace());

        // Customize your response object to display the exception details

        $stackTraceForEnvErrors = [];
        
        if ($debug === "dev") {
            $stackTraceForEnvErrors = $stackTraceErrors;
            $message = $exception->getMessage();
        } else {
            $message = 'Bilinmeyen bir hata meydana geldi.';
        }
        

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response = ApiResponse::createErrorResponse($exception->getStatusCode(), $message, $stackTraceForEnvErrors);
        } else {
            $response = ApiResponse::createErrorResponse(500, $message, $stackTraceForEnvErrors);
        }
        $response->setMessage($message);

        $content = $this->serializer->serialize($response, 'json',
                SerializationContext::create()->setSerializeNull(false));
        // sends the modified response object to the event
        $event->setResponse(new Response($content));
    }

    public function formatStackTraceErrors($errors)
    {
        $debugErrors = [];

        foreach ($errors as $key => $value) {
            if (array_key_exists('file', $value)) {
                $debugErrors[ $key ]['file'] = $value['file'];
            }
            if (array_key_exists('line', $value)) {
                $debugErrors[ $key ]['line'] = $value['line'];
            }
            if (array_key_exists('function', $value)) {
                $debugErrors[ $key ]['function'] = $value['function'];
            }
            if (array_key_exists('class', $value)) {
                $debugErrors[ $key ]['class'] = $value['class'];
            }
        }

        return $debugErrors;
    }
}