<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;
use function strlen;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class ProtocolHandlerController extends AbstractController
{
    #[Route('/handler', name: 'app_protocol_handler')]
    public function __invoke(Request $request): Response
    {
        if (! str_starts_with((string) $request->query->get('type'), 'web+pwabundle://')) {
            throw $this->createNotFoundException();
        }

        $route = substr((string) $request->query->get('type'), strlen('web+pwabundle://'));
        try {
            return $this->redirectToRoute($route);
        } catch (Throwable) {
            throw $this->createNotFoundException();
        }
    }
}
