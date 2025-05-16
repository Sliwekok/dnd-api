<?php
declare(strict_types=1);

namespace App\Controller\Api\v2024;

use App\Controller\Api\ApiController;
use App\Document\Spell;
use App\Repository\SpellRepository;
use App\Service\ValidationService;
use App\UniqueNameInterface\HttpCodesInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/2024/spell')]

class SpellController extends ApiController {

    public function __construct (
        private ValidationService   $validationService,
        private SpellRepository     $repository,
    ) {}

	#[Route('', name: '2024_api_spell_list', methods: ['GET'])]
	public function getList(
        Request $request
    ): JsonResponse {
        $getData = $request->query->all();
        $validationResponse = $this->validationService->validateRequestData($getData, Spell::class);

        if ($validationResponse) {
            return $validationResponse;
        }

        $items = !empty($getData) ? $this->repository->getList($getData) : $this->repository->getList();


        return $this->respond($items, HttpCodesInterface::SUCCESS);
	}

	#[Route('/{item}', name: '2024_api_spell_single', methods: ['GET'])]
	public function getSingle(string $item): JsonResponse {
        $item = $this->repository->getSingle($item);

        return $this->respond($item, HttpCodesInterface::SUCCESS);
	}
}
