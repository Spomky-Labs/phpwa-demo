<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class ShareTargetController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr',
    ])]
    #[Route('/share-target', name: 'app_feature_share_target', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        return $this->render('features/share_target.html.twig', [
            'data' => [
                'url' => $request->request->get('url', 'No URL provided'),
                'title' => $request->request->get('title', 'No title provided'),
                'text' => $request->request->get('text', 'No text provided'),
                'files' => $request->files->all(),
            ],
        ]);
    }
}
