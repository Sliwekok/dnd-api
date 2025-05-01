<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend')]
class BackendController extends AbstractController
{
	#[Route('/', name: 'backend_index')]
	public function index(
		Request     $request
	): Response {

		return $this->render('admin/index.html.twig', []);
	}

	#[Route('/add/{type}', name: 'backend_add')]
	public function add(
		Request     $request,
        string      $type
	): Response {
        $page = match ($type) {
            'spell' => 'backend/add/spell.twig.html',
            'race'  => 'backend/add/race.twig.html',
            'class' => 'backend/add/class.twig.html',
            default => throw new \InvalidArgumentException('Invalid type'),
        };


        if ($request->getMethod() === 'POST') {
//            if ()

            $data = $request->request->all();
        }

		return $this->render($page, []);
	}

    #[Route('/browse/{type}', name: 'backend_browse')]
    public function browse(
        Request     $request,
        string      $type
    ): Response {
        $page = match ($type) {
            'spell' => 'backend/browse/spell.twig.html',
            'race'  => 'backend/browse/race.twig.html',
            'class' => 'backend/browse/class.twig.html',
            default => throw new \InvalidArgumentException('Invalid type'),
        };

        return $this->render($page, []);
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request     $request
    ): JsonResponse {
	    $data = json_decode($request->getContent(), true);
	    $password = $data['password'] ?? '';

        if ($password === $_ENV['ADMIN_PASSWORD']) {
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

    #[Route('/home', name: 'home')]
    public function home(
        Request     $request
    ): Response {

        return $this->render('admin/add.html.twig', []);
    }

}
