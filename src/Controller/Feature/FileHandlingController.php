<?php

namespace App\Controller\Feature;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class FileHandlingController extends AbstractController
{
    #[Route('/file-handling', name: 'app_feature_file_handling', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/file_handling.html.twig');
    }
}