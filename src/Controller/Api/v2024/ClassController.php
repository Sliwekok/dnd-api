<?php
declare(strict_types=1);

namespace App\Controller\Api\v2024;

use App\Controller\Api\ApiController;
use App\Document\CharacterClass;
use App\Repository\ClassRepository;
use App\Service\ValidationService;
use App\UniqueNameInterface\HttpCodesInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/2024/class')]

class ClassController extends ApiController {

    public function __construct (
        private ValidationService   $validationService,
        private ClassRepository     $repository,
    ) {}

	#[Route('/', name: '2024_api_class_list', methods: ['GET'])]
	public function getList(Request $request): JsonResponse {
        $getData = $request->query->all();
        $validationResponse = $this->validationService->validateRequestData($getData, CharacterClass::class);

        if ($validationResponse) {
            return $validationResponse;
        }

        $items = !empty($getData) ? $this->repository->getList($getData) : $this->repository->getList();

        return $this->respond($items, HttpCodesInterface::SUCCESS);
	}

    #[Route('/{item}', name: '2024_api_class_details', methods: ['GET'])]
    public function details(string $item): JsonResponse {
        $item = $this->repository->getSingle($item);

        return $this->respond($item, HttpCodesInterface::SUCCESS);
    }
}
