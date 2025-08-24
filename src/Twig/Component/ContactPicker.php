<?php

declare(strict_types=1);

namespace App\Twig\Component;

use Symfony\Component\String\AbstractUnicodeString;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use function Symfony\Component\String\s;

#[AsLiveComponent('ContactPicker')]
class ContactPicker
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public array $contacts = [];

    #[LiveProp]
    public bool $available = true;

    #[LiveListener('selection')]
    public function onUpdate(#[LiveArg] array $contacts): void
    {
        foreach ($contacts as $id => $contact) {
            if (!array_key_exists('tel', $contact)) {
                $contact['tel'] = [];
            }
            foreach ($contact['tel'] as $p => $phone) {
                $contact['tel'][$p] = $this->sanitizePhone($phone);
            }
            $contact['name'] = array_unique($contact['name']);
            $contact['email'] = array_unique($contact['email']);
            $contact['tel'] = array_unique($contact['tel']);
            $contacts[$id] = $contact;
        }

        $this->contacts = $contacts;
    }

    #[LiveListener('unavailable')]
    public function unavailable(): void
    {
        $this->available = false;
    }

    private function sanitizePhone(string $input): string
    {
        return s($input)
            ->normalize(AbstractUnicodeString::NFKD)
            ->replaceMatches('/\D+/u', '')
            ->prepend('+')
            ->toString();
    }
}
