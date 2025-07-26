<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

final readonly class PermissionPolicyEventListener
{
    #[AsEventListener()]
    public function addHeader(ResponseEvent $event): void
    {
        if ($event->isMainRequest()) {
            $event->getResponse()
                ->headers->set(
                    'Permissions-Policy',
                    'interest-cohort=(), accelerometer=(self), autoplay=(self), camera=(self), encrypted-media=(self), fullscreen=(self), geolocation=(self), magnetometer=(self), microphone=(self), midi=(self), payment=(self), picture-in-picture=(self), sync-xhr=(self), usb=(self)'
                );
        }
    }
}
