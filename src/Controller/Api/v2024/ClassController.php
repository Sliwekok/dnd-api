<?php
declare(strict_types=1);

namespace App\Controller\Api\v2024;

use App\Controller\Api\ApiController;
use App\Document\CharacterClass;
use App\Repository\ClassRepository;
use App\Helper\ValidateData;
use App\UniqueNameInterface\HttpCodesInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/2024/class')]

class ClassController extends ApiController {

    public function __construct (
        private DocumentManager $dm,
        private ClassRepository $repository,
    ) {}

	#[Route('/', name: '2024_api_class_list', methods: ['GET'])]
	public function getList(Request $request): JsonResponse {
        $validateData = new ValidateData($this->dm);
        $getData = $request->query->all();
        if (!empty($getData)) {
            $columnValidator = $validateData->checkColumns($getData,CharacterClass::class);
            if (!$columnValidator) return $this->respond(['msg' => 'Invalid data column names'], HttpCodesInterface::BAD_REQUEST);

            $valueValidator = $validateData->checkColumnsValueTypes($getData, CharacterClass::class);
            if (!$valueValidator) return $this->respond(['msg' => 'Invalid data column value types'], HttpCodesInterface::BAD_REQUEST);

            $items = $this->repository->getList($getData);
        } else {
            $items = $this->repository->getList();
        }
        return $this->respond($items, HttpCodesInterface::SUCCESS);
	}

    #[Route('/{item}', name: '2024_api_class_details', methods: ['GET'])]
    public function details(string $item): JsonResponse {
        $item = $this->repository->getSingle($item);
        return $this->respond($item, HttpCodesInterface::SUCCESS);
    }
}
