<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
	public function respond(
        array   $data,
        int     $status = 200,
	): JsonResponse {

        return $this->json($data, $status);
	}
}
