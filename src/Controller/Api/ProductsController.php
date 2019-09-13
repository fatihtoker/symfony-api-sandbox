<?php

namespace App\Controller\Api;

use App\Response\ApiResponse;
use App\Service\ProductsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;

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
        $data = $service->getAll($request, true);
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

     /**
     * @Route("/{id}", methods={"GET"})
     * @param ProductsService $service
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getProductAction(Request $request, ProductsService $service, $id)
    {
        $response = $service->getProduct($request, $id);
        return $this->createJsonResponse($response, ['products_list']);
    }
}
