<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use DateTimeImmutable;
use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PeriodicSyncController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr',
    ])]
    #[Route('/{_locale<%app.supported_locales_regex%>}/periodic-sync', name: 'app_feature_periodic_sync', methods: [
        Request::METHOD_GET,
    ])]
    public function __invoke(): Response
    {
        return $this->render('features/periodic_sync.html.twig');
    }

    #[Route('/ping', name: 'app_ping')]
    public function ping(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'updated_at' => new DateTimeImmutable()
                ->format('Y-m-d H:i:s'),
        ]);
    }
}
