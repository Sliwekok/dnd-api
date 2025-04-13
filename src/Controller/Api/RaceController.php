<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/2024/race')]

class RaceController extends AbstractController {

	#[Route('/', name: '2024_api_race_list', methods: ['GET'])]
	public function getList(Request $request): JsonResponse {
		return $this->json(['test' => 'test']);
	}

}
