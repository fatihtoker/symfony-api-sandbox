<?php

namespace App\Controller;

use App\Controller\Api\ApiController;
use App\Response\ApiResponse;

class DefaultController extends ApiController
{
    public function defaultAction()
    {
        return $this->createJsonResponse(ApiResponse::createErrorResponse(500, 'Server error. Please be sure to add \'api\' prefix to the URL.', []));
    }
}