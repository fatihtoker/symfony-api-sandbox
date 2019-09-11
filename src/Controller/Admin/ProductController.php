<?php

namespace App\Controller\Admin;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UsersService;
use App\Service\ProductsService;

/**
 * @Route("/products")
 * @IsGranted("ROLE_ADMIN")
 */
class ProductController extends ApiController
{
    /**
     * @Route("", name="products-index", methods={"GET"})
     */
    public function getProductsAction(Request $request, ProductsService $service)
    {
        $data = $service->getAll($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data));
    }

    /**
     * @Route("/categories", name="products-categories", methods={"GET"})
     */
    public function getCategoriesAction(Request $request, ProductsService $service)
    {
        $data = $service->getCategories($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data));
    }

    /**
     * @Route("/types", name="products-types", methods={"GET"})
     */
    public function getTypesAction(Request $request, ProductsService $service)
    {
        $data = $service->getTypes($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data));
    }


    /**
     * @Route("/create", name="add-products", methods={"POST"})
     */
    public function createProductAction(Request $request, ProductsService $service)
    {
        $response = $service->create($request);
        return $this->createJsonResponse($response);
    }

    /**
     * @Route("/delete/{id}", name="delete-products", methods={"POST"})
     */
    public function deleteUserAction(int $id, ProductsService $service)
    {
        $response = $service->delete($id);

        return $this->createJsonResponse($response);
    }
}
