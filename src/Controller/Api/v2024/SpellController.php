<?php
declare(strict_types=1);

namespace App\Controller\Api\v2024;

use App\Controller\Api\ApiController;
use App\Document\Spell;
use App\Repository\SpellRepository;
use App\UniqueNameInterface\HttpCodesInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Helper\ValidateData;

#[Route('/api/2024/spell')]

class SpellController extends ApiController {

	public function __construct (
		private DocumentManager $dm,
        private SpellRepository $repository,
	) {}

	#[Route('', name: '2024_api_spell_list', methods: ['GET'])]
	public function getList(
        Request $request
    ): JsonResponse {
        $validateData = new ValidateData($this->dm);
        $getData = $request->query->all();
        if (!empty($getData)) {
            $validator = $validateData->checkColumns(
                $getData,
                Spell::class
            );

            if (!$validator) return $this->respond(['msg' => 'Invalid data column names'], HttpCodesInterface::BAD_REQUEST);
            $spells = $this->repository->getList($getData);
        } else {
            $spells = $this->repository->getList();
        }
		return $this->respond($spells, HttpCodesInterface::SUCCESS);
	}

	#[Route('/{name}', name: '2024_api_spell_single', methods: ['GET'])]
	public function getSingle(string $name): JsonResponse {
        $spell = $this->repository->getSingle($name);
		return $this->respond($spell, HttpCodesInterface::SUCCESS);
	}
}
