<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use const STR_PAD_LEFT;

#[AsLiveComponent('Battery')]
class Battery
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public string $charging = '';

    #[LiveProp]
    public string $level = '';

    #[LiveProp]
    public string $chargingTime = '';

    #[LiveProp]
    public string $dischargingTime = '';

    #[LiveListener('updated')]
    public function onUpdate(
        #[LiveArg]
        bool $charging,
        #[LiveArg]
        float $level,
        #[LiveArg]
        ?int $chargingTime,
        #[LiveArg]
        ?int $dischargingTime,
    ): void {
        $this->charging = $charging ? 'Yes' : 'No';
        $this->level = ($level * 100) . '%';
        $this->chargingTime = $this->formatSeconds($chargingTime);
        $this->dischargingTime = $this->formatSeconds($dischargingTime);
    }

    private function formatSeconds(?float $s): string
    {
        if ($s === null || ! is_finite($s)) {
            return '∞';
        }

        if ($s === 0.0) {
            return 'done';
        }

        $h = str_pad((string) floor($s / 3600), 2, '0', STR_PAD_LEFT);
        $m = str_pad((string) floor(($s % 3600) / 60), 2, '0', STR_PAD_LEFT);
        $sec = str_pad((string) floor($s % 60), 2, '0', STR_PAD_LEFT);

        return "{$h}:{$m}:{$sec}";
    }
}
