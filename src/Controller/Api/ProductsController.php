<?php

namespace App\Controller\Api;

use App\Response\ApiResponse;
use App\Service\ProductsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductsController extends ApiController
{
    /**
     * @Route("", methods={"GET"})
     * @param ProductsService $service
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getProductsAction(Request $request, ProductsService $service)
    {
        $data = $service->getAll($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data), ['products_list']);
    }

    /**
     * @Route("/category", methods={"GET"})
     * @param ProductsService $service
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProductsWithCategoryAction(ProductsService $service)
    {
        $data = $service->getAllByCategory();
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data), ['product_category']);
    }
}
