<?php

namespace App\Controller\Admin;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends ApiController
{
    /**
     * @Route("", name="admin")
     */
    public function index()
    {
        return $this->createJsonResponse(ApiResponse::createSuccessResponse([], 'Helal len sana'));
    }
}
