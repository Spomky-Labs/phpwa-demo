<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BackgroundSyncController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr',
    ])]
    #[Route('/{_locale<%app.supported_locales_regex%>}/background-sync', name: 'app_feature_background_sync', methods: [
        Request::METHOD_GET,
    ])]
    public function __invoke(): Response
    {
        return $this->render('features/background_sync.html.twig');
    }

    #[Route('/form/data', name: 'app_feature_background_sync_post', methods: [Request::METHOD_POST])]
    public function post(): Response
    {
        return $this->redirectToRoute('app_feature_background_sync');
    }
}
