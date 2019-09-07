<?php

namespace App\Controller\Admin;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MenusService;
use Symfony\Component\HttpFoundation\Request;
use App\Service\UsersService;

/**
 * @Route("/users")
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends ApiController
{
    /**
     * @Route("", name="users-index", methods={"GET"})
     */
    public function getUsersAction(Request $request, UsersService $service)
    {
        $data = $service->getAll($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data), ['user_list']);
    }

    /**
     * @Route("/create", name="add-user", methods={"POST"})
     */
    public function createUserAction(Request $request, UsersService $service)
    {
        $response = $service->create($request);
        return $this->createJsonResponse($response);
    }

    /**
     * @Route("/delete/{id}", name="delete-user", methods={"POST"})
     */
    public function deleteUserAction(int $id, UsersService $service)
    {
        $response = $service->delete($id);

        return $this->createJsonResponse($response);
    }
}
