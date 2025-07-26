<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Update')]
class Update
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public string $status = 'unknown';

    #[LiveListener('update-available')]
    public function onInstalled(): void
    {
        $this->status = 'update-available';
    }
}
