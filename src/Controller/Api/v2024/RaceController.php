<?php
declare(strict_types=1);

namespace App\Controller\Api\v2024;

use App\Controller\Api\ApiController;
use App\Document\Race;
use App\Helper\ValidateData;
use App\Repository\RaceRepository;
use App\UniqueNameInterface\HttpCodesInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/2024/race')]

class RaceController extends ApiController {

	public function __construct (
		private DocumentManager $dm,
        private RaceRepository  $repository
	) {}

    #[Route('/', name: '2024_api_race_list', methods: ['GET'])]
    public function getList(Request $request): JsonResponse {
        $validateData = new ValidateData($this->dm);
        $getData = $request->query->all();
        if (!empty($getData)) {
            $columnValidator = $validateData->checkColumns($getData,Race::class);
            if (!$columnValidator) return $this->respond(['msg' => 'Invalid data column names'], HttpCodesInterface::BAD_REQUEST);

            $valueValidator = $validateData->checkColumnsValueTypes($getData, Race::class);
            if (!$valueValidator) return $this->respond(['msg' => 'Invalid data column value types'], HttpCodesInterface::BAD_REQUEST);

            $items = $this->repository->getList($getData);
        } else {
            $items = $this->repository->getList();
        }
        return $this->respond($items, HttpCodesInterface::SUCCESS);
    }

	#[Route('/{item}', name: '2024_api_race_single', methods: ['GET'])]
	public function getSingle(string $item): JsonResponse {
        $item = $this->repository->getSingle($item);
		return $this->json($item, HttpCodesInterface::SUCCESS);
	}
}
