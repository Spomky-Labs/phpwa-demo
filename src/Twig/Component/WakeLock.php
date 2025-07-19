<?php

namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;

#[AsLiveComponent('WakeLock')]
class WakeLock
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public string $status = 'unknown';

    /**
     * @param array{type: string, released: bool}|null $wakeLock
     */
    #[LiveListener('updated')]
    public function onUpdate(
        #[LiveArg] ?array $wakeLock,
    ): void {
        $this->status = $wakeLock === null ? 'unlocked': 'locked';
    }
}
