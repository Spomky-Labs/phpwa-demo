<?php

namespace App\Controller\Feature;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class WebShareController extends AbstractController
{
    #[Route('/web-share', name: 'app_feature_web_share', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/web_share.html.twig');
    }
}