<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Geolocation')]
class Geolocation
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp()]
    public int $zoom = 3;

    #[LiveProp()]
    public float $latitude = 0.0;

    #[LiveProp()]
    public float $longitude = 0.0;

    /**
     * @param array{coords: array{latitude: float, longitude: float}} $position
     */
    #[LiveListener('position')]
    public function onPosition(#[LiveArg] array $position): void
    {
        $this->latitude = $position['coords']['latitude'];
        $this->longitude = $position['coords']['longitude'];
        $this->zoom = 12;
    }
}
