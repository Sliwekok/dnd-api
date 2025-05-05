<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	#[Route('/', name: 'index', methods: ['GET'])]
	public function index(
		Request     $request
	): Response {

		return $this->render('index.html.twig', []);
	}

	#[Route('/home', name: 'home', methods: ['GET'])]
	public function home(
		Request     $request
	): Response {

		return $this->render('index.html.twig', []);
	}
}
