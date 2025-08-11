<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class FileSystemController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr',
    ])]
    #[Route('/file-system', name: 'app_feature_file_system', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/file_system.html.twig');
    }
}
