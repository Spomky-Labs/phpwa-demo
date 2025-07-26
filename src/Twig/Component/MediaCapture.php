<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use WebPush\WebPush;

#[AsLiveComponent('MediaCapture')]
class MediaCapture
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public string $status = 'unknown';

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly WebPush $webpushService
    ) {
    }

    #[LiveListener('error')]
    public function onError(#[LiveArg] mixed $error): void
    {
        dd($error);
    }
}
