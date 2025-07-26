<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Installation')]
class Installation
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public string $status = 'unknown';

    #[LiveListener('installed')]
    public function onInstalled(): void
    {
        $this->status = 'installed';
    }

    #[LiveListener('not-installed')]
    public function onNotInstalled(): void
    {
        $this->status = 'not-installed';
    }

    #[LiveListener('installing')]
    public function onInstalling(): void
    {
        $this->status = 'installing';
    }

    #[LiveListener('cancelled')]
    public function onCancelled(): void
    {
        $this->status = 'cancelled';
    }
}
