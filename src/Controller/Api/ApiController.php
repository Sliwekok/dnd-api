<?php

namespace App\Controller\Api;

use App\UniqueNameInterface\HttpCodesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
	public function respond(
        ?array  $data,
        int     $status = 200,
	): JsonResponse {
		if (empty($data)) {
			return $this->json([
				'message' => 'No data found',
			                   ], HttpCodesInterface::NO_CONTENT);
		}

        return $this->json($data, $status);
	}
}
