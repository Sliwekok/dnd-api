<?php

namespace App\Controller\Backend;

use App\Document\Background;
use App\Document\CharacterClass;
use App\Document\Languages;
use App\Document\Monster;
use App\Document\Race;
use App\Document\Spell;
use App\Document\Traits;
use App\Form\BackgroundFormInterface;
use App\Form\CharacterClassFormInterface;
use App\Form\LanguageFormInterface;
use App\Form\MonsterFormInterface;
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
            case 'class':
                $item = new CharacterClass();
                $page = 'backend/add/class.html.twig';
                $form = $this->createForm(CharacterClassFormInterface::class, $item);
                break;
            case 'language':
                $item = new Languages();
                $page = 'backend/add/languages.html.twig';
                $form = $this->createForm(LanguageFormInterface::class, $item);
                break;
	        case 'background':
		        $item = new Background();
		        $page = 'backend/add/background.html.twig';
		        $form = $this->createForm(BackgroundFormInterface::class, $item);
		        break;
	        case 'monster':
		        $item = new Monster();
		        $page = 'backend/add/monster.html.twig';
		        $form = $this->createForm(MonsterFormInterface::class, $item);
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
            case 'race':
                $items = $dm->getRepository(Race::class)->findAll();
                $page = 'backend/browse/race.html.twig';
                break;
	        case 'traits':
		        $items = $dm->getRepository(Traits::class)->findAll();
		        $page = 'backend/browse/traits.html.twig';
		        break;
            case 'class':
                $items = $dm->getRepository(CharacterClass::class)->findAll();
                $page = 'backend/browse/class.html.twig';
                break;
            case 'language':
                $items = $dm->getRepository(Languages::class)->findAll();
                $page = 'backend/browse/languages.html.twig';
                break;
	        case 'background':
		        $items = $dm->getRepository(Background::class)->findAll();
		        $page = 'backend/browse/background.html.twig';
		        break;
	        case 'monster':
		        $items = $dm->getRepository(Monster::class)->findAll();
		        $page = 'backend/browse/monster.html.twig';
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
			case 'class':
				$item = $dm->getRepository(CharacterClass::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/class.html.twig';
				$form = $this->createForm(CharacterClassFormInterface::class, $item);
				break;
			case 'language':
				$item = $dm->getRepository(Languages::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/language.html.twig';
				$form = $this->createForm(LanguageFormInterface::class, $item);
				break;
			case 'background':
				$item = $dm->getRepository(Background::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/backgorund.html.twig';
				$form = $this->createForm(BackgroundFormInterface::class, $item);
				break;
			case 'monster':
				$item = $dm->getRepository(Monster::class)->findOneBy(['nameGeneric' => $name]);
				$page = 'backend/add/monster.html.twig';
				$form = $this->createForm(MonsterFormInterface::class, $item);
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

    #[Route('/delete/{type}/{name}', name: 'backend_delete', methods: ['GET'])]
    public function delete (
        Request $request,
        string $type,
        string $name,
        DocumentManager $dm
    ): Response {
        switch ($type) {
            case 'spell':
                $repository = $dm->getRepository(Spell::class);
                break;
            case 'race':
                $repository = $dm->getRepository(Race::class);
                break;
            case 'traits':
                $repository = $dm->getRepository(Traits::class);
                break;
            case 'class':
                $repository = $dm->getRepository(CharacterClass::class);
                break;
            case 'language':
                $repository = $dm->getRepository(Languages::class);
                break;
            case 'background':
                $repository = $dm->getRepository(Background::class);
                break;
	        case 'monster':
		        $repository = $dm->getRepository(Monster::class);
		        break;
            default:
                throw new \InvalidArgumentException('Invalid type');
        }

        $item = $repository->findOneBy(['nameGeneric' => $name]);
        if (!$item) {
            throw $this->createNotFoundException('Item not found');
        }
        $dm->remove($item);
        $dm->flush();
        $this->addFlash('success', 'Item deleted successfully!');

        return $this->redirectToRoute('backend_browse', ['type' => $type]);
    }

}
