<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PresentationController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en_US',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr_FR',
    ])]
    #[Route('/presentation', name: 'app_feature_presentation', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/presentation.html.twig');
    }

    #[PreloadUrl('pages', [
        '_locale' => 'en_US',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr_FR',
    ])]
    #[Route('/{_locale<%app.supported_locales_regex%>}/receiver', name: 'app_feature_receiver', methods: [
        Request::METHOD_GET,
    ])]
    public function receiver(): Response
    {
        return $this->render('features/receiver.html.twig');
    }
}
