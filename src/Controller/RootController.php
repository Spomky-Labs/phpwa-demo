<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RootController extends AbstractController
{
    /**
     * @param array{string} $supportedLocales
     */
    public function __construct(
        #[Autowire(param: 'app.default_locale')]
        private readonly string $defaultLocale,
        #[Autowire(param: 'app.supported_locales')]
        private readonly array $supportedLocales,
    ) {
    }

    #[Route('/', name: 'app_root', methods: [Request::METHOD_GET])]
    public function __invoke(Request $request): Response
    {
        $locale =
            $request->attributes->get('_locale') ??
            $request->getSession()
                ->get('_locale') ??
            $request->getPreferredLanguage($this->supportedLocales) ??
            $this->defaultLocale
        ;

        return $this->redirectToRoute('app_homepage', [
            '_locale' => $locale,
        ], Response::HTTP_SEE_OTHER);
    }
}
