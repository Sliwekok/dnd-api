<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/')]
class AdminController extends AbstractController
{
	#[Route('/', name: 'index')]
	public function index(
		Request     $request
	): Response {

		return $this->render('admin/index.html.twig', []);
	}

	#[Route('/home', name: 'home')]
	public function home(
		Request     $request
	): Response {

		return $this->render('admin/add.html.twig', []);
	}

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request     $request
    ): JsonResponse {
        if ($request->request->get('password') == $_ENV['ADMIN_PASSWORD']) {
            $this->addFlash('success', 'Login successful');
        } else {
            $this->addFlash('error', 'Invalid password');
            return $this->json([
                'status' => 'error',
                'message' => 'Invalid password',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'status' => 'success',
            'message' => 'Login successful',
        ], Response::HTTP_OK);
    }
}
