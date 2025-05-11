<?php

namespace App\Controller\Backend;

use App\Document\Race;
use App\Document\Spell;
use App\Document\Traits;
use App\Form\RaceFormInterface;
use App\Form\SpellAddFormType;
use App\Form\TraitsFormInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend')]
class BackendController extends AbstractController
{
	#[Route('/', name: 'backend_index', methods: ['GET'])]
	public function index(
	): Response {
		return $this->render('backend/index.html.twig', []);
	}

	#[Route('/add/{type}', name: 'backend_add', methods: ['GET', 'POST'])]
	public function add(
		Request         $request,
        string          $type,
        DocumentManager $dm
	): Response {
        switch ($type) {
            case 'spell':
                $item = new Spell();
                $page = 'backend/add/spell.html.twig';
                $form = $this->createForm(SpellAddFormType::class, $item);
                break;
	        case 'race':
				$item = new Race();
				$page = 'backend/add/race.html.twig';
				$form = $this->createForm(RaceFormInterface::class, $item);
				break;
	        case 'traits':
		        $item = new Traits();
		        $page = 'backend/add/traits.html.twig';
		        $form = $this->createForm(TraitsFormInterface::class, $item);
		        break;
            default:
                throw new \InvalidArgumentException('Invalid type');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
	            $formData = $form->getData();
	            if (method_exists($formData, 'setNameGeneric')) {
		            $nameGeneric = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($formData->getName()));
		            $formData->setNameGeneric($nameGeneric);
	            }
	            $formData->setAccepted(true);

                $dm->persist($formData);
                $dm->flush();

                $this->addFlash('success', 'Item added successfully!');

                return $this->redirectToRoute('backend_add', ['type' => $type]);
            } else {
                $this->addFlash('error', 'There were errors in the form. Please fix them.');
            }
        }
		return $this->render($page, [
            'form' => $form
        ]);
	}

    #[Route('/browse/{type}', name: 'backend_browse', methods: ['GET', 'POST'])]
    public function browse(
        DocumentManager $dm,
        string          $type
    ): Response
    {
        switch ($type) {
            case 'spell':
                $items = $dm->getRepository(Spell::class)->findAll();
                $page = 'backend/browse/spell.html.twig';
                break;
	        case 'traits':
		        $items = $dm->getRepository(Traits::class)->findAll();
		        $page = 'backend/browse/traits.html.twig';
		        break;
            default:
                throw new \InvalidArgumentException('Invalid type');
        }

        return $this->render($page, [
            'items' => $items
        ]);
    }

	#[Route('/edit/{type}/{name}', name: 'backend_edit', methods: ['GET', 'POST'])]
	public function edit(
		Request $request,
		string  $name,
		string  $type,
		DocumentManager $dm
	): Response {
		switch ($type) {
			case 'spell':
				$item = $dm->getRepository(Spell::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/spell.html.twig';
				$form = $this->createForm(SpellAddFormType::class, $item);
				break;
			case 'race':
				$item = $dm->getRepository(Race::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/race.html.twig';
				$form = $this->createForm(RaceFormInterface::class, $item);
				break;
			case 'traits':
				$item = $dm->getRepository(Traits::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/traits.html.twig';
				$form = $this->createForm(TraitsFormInterface::class, $item);
				break;
			default:
				throw new \InvalidArgumentException('Invalid type');
		}

		if (!$item) {
			throw $this->createNotFoundException('Item not found');
		}

		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				$formData = $form->getData();
				if (method_exists($formData, 'setNameGeneric')) {
					$nameGeneric = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($formData->getName()));
					$formData->setNameGeneric($nameGeneric);
				}
				$formData->setAccepted(true);

				$dm->persist($formData);
				$dm->flush();

				$this->addFlash('success', 'Item updated successfully!');

				return $this->redirectToRoute('backend_browse', ['type' => $type]);
			} else {
				$this->addFlash('error', 'There were errors in the form. Please fix them.');
			}
		}

		return $this->render($page, [
			'form' => $form
		]);
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

    #[Route('/home', name: 'home', methods: ['GET'])]
    public function home(
        Request     $request
    ): Response {

        return $this->render('backend/add.html.twig', []);
    }

}
