<?php

namespace App\Controller\Admin;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\RoleService;

/**
 * @Route("/roles")
 * @IsGranted("ROLE_ADMIN")
 */
class RoleController extends ApiController
{
    /**
     * @Route("", name="roles-index", methods={"GET"})
     */
    public function getRolesAction(Request $request, RoleService $service)
    {
        $data = $service->getAll($request);
        return $this->createJsonResponse(ApiResponse::createSuccessResponse($data));
    }
}
