<?php

declare(strict_types=1);

namespace App\Controller\Feature;

use SpomkyLabs\PwaBundle\Attribute\PreloadUrl;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales_regex%>}')]
class PaymentController extends AbstractController
{
    #[PreloadUrl('pages', [
        '_locale' => 'en',
    ])]
    #[PreloadUrl('pages', [
        '_locale' => 'fr',
    ])]
    #[Route('/payment', name: 'app_feature_payment', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('features/payment.html.twig');
    }
}
