<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Response\ApiResponse;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends ApiController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/products", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getProductsAction()
    {
        $productRepo = $this->em->getRepository(Product::class);
        $data = $productRepo->findAll();
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data));
    }

    /**
     * @Rest\Get("/products/create")
     */
    public function newProductAction()
    {
        for ($i = 0; $i<10; $i++) {
            $product[$i] = new Product();
            $product[$i]->setName('dummyName' . $i);
            $product[$i]->setDescription('dummyDesc' . $i);
            $product[$i]->setPrice(10 * $i);
            $product[$i]->setOnSale(true);
            $this->em->persist($product[$i]);
        }
        $this->em->flush();

        return $this->json(['message' => '10 yeni kullanıcı eklendi']);
    }
}
