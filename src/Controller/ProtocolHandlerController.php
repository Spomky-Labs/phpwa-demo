<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class ProtocolHandlerController extends AbstractController
{
    #[Route('/handler', name: 'app_protocol_handler')]
    public function __invoke(Request $request): Response
    {
        return match (true) {
            str_starts_with($request->query->get('type'), 'web+pwabundle://geolocation') => $this->redirectToRoute(
                'app_feature_geolocation'
            ),
            str_starts_with($request->query->get('type'), 'web+pwabundle://screen-capturing') => $this->redirectToRoute(
                'app_feature_screen_capture'
            ),
            default => throw $this->createNotFoundException(),
        };
    }
}
