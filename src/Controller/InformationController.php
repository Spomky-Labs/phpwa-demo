<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class InformationController extends AbstractController
{
    #[Route('/information', name: 'app_information', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('information/index.html.twig');
    }
}