<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Document\Race;
use App\UniqueNameInterface\HttpCodesInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/2024/race')]

class RaceController extends AbstractController {

	public function __construct (
		private DocumentManager $dm,
	) {}

	#[Route('/', name: '2024_api_race_list', methods: ['GET'])]
	public function getList(): JsonResponse {
		$races = $this->dm->getRepository(Race::class)->findAll();
		return $this->json($races, HttpCodesInterface::SUCCESS);
	}

	#[Route('/{race}', name: '2024_api_race_single', methods: ['GET'])]
	public function getSingle(string $race): JsonResponse {
		$races = $this->dm->getRepository(Race::class)->findBy(['nameGeneric' => $race]);
		return $this->json($races, HttpCodesInterface::SUCCESS);
	}

}
