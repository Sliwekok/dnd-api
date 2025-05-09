<?php

namespace App\Controller\Docs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/docs')]
class DocsController extends AbstractController
{
    #[Route('/', name: 'docs_index', methods: ['GET'])]
    public function index (
        Request     $request
    ): Response {

        return $this->render('index.html.twig', []);
    }
}
