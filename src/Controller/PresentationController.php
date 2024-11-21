<?php

namespace App\Controller;

use App\Form\ItemHandler;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}/presentation')]
class PresentationController extends AbstractController
{
    #[Route('/1', name: 'presentation', methods: [Request::METHOD_GET])]
    public function success(): Response
    {
        return $this->render('presentation/1.html.twig');
    }
}
