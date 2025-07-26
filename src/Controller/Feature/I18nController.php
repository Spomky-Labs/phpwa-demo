<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class I18nController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en_US',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr_FR',
    ])]
    #[Route('/i18n', name: 'app_feature_i18n', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/i18n.html.twig');
    }
}
