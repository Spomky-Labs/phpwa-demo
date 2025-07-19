<?php

namespace App\Twig\Component;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use WebPush\Action;
use WebPush\Message;
use WebPush\Notification;
use WebPush\Subscription;

#[AsLiveComponent('WebPush')]
class WebPush
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    public function __construct(
        private readonly RouterInterface $router,
        private readonly \WebPush\WebPush $webpushService
    ) {
    }

    #[LiveProp]
    public string $status = 'unknown';

    #[LiveProp]
    public ?string $subscription = null;

    /**
     * @param array{auth: string, p256dh: string} $keys
     * @param string[] $supportedContentEncodings
     */
    #[LiveListener('subscribed')]
    public function onSubscription(
        #[LiveArg] string $endpoint,
        #[LiveArg] array $keys,
        #[LiveArg] array $supportedContentEncodings
    ): void {
        $this->status = 'subscribed';
        $this->subscription = json_encode([
            'endpoint' => $endpoint,
            'keys' => $keys,
            'supportedContentEncodings' => $supportedContentEncodings,
        ]);
    }

    #[LiveListener('unsubscribed')]
    public function onUnsubscription(
    ): void {
        $this->status = 'unsubscribed';
    }

    #[LiveAction]
    public function notify(
    ): void {
        if ($this->subscription === null) {
            return;
        }
        $subscription = Subscription::createFromString($this->subscription);
        $message = Message::create('My super Application.', 'Hello World! Clic on the body to go to GitHub')
            ->vibrate(200, 300, 200, 300)
            ->withImage('https://picsum.photos/1024/512')
            ->withIcon('https://picsum.photos/512/512')
            ->withBadge('https://picsum.photos/256/256')
            ->withLang('fr_FR')
            ->mute()
            ->unmute()
            ->auto()
            ->withData(json_encode([
                'action1' => $this->router->generate('app_feature_battery', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
                'action2' => $this->router->generate('app_feature_barcode_detection', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
                'default' => 'https://github.com',
            ]))
            ->withTimestamp(time()*1000)
            ->addAction(Action::create('action1', 'Battery'))
            ->addAction(Action::create('action2', 'Barcode'));
        ;
        $notification = Notification::create()
            ->withPayload($message->toString());

        $statusReport = $this->webpushService->send($notification, $subscription);
        // Check the status of the notification
    }
}
