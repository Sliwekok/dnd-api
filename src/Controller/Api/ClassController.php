<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/2024/class')]

class ClassController extends AbstractController {

	#[Route('/', name: '2024_api_class_list', methods: ['GET'])]
	public function getList(Request $request): JsonResponse {
		return $this->json(['test' => 'test']);
	}

    #[Route('/{class}', name: '2024_api_class_details', methods: ['GET'])]
    public function details(Request $request, string $class): JsonResponse {
        return $this->json(['test' => $class]);
    }
}
