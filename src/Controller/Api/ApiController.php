<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
	#[Route('/', name: 'api', methods: ['GET'])]
	public function api (
		Request     $request
	): Response {

		return $this->render('index.html.twig', []);
	}
}
