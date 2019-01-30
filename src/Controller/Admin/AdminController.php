<?php

namespace App\Controller\Admin;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends ApiController
{
    /**
     * @Route("/login_check", name="admin", methods={"POST"})
     */
    public function loginCheck()
    {
    }

    /**
     * @Route("", methods={"GET"}, name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function indexAction()
    {
        return $this->createJsonResponse(ApiResponse::createSuccessResponse([], 'User is granted. This is a friendly message from developer.'));
    }
}
