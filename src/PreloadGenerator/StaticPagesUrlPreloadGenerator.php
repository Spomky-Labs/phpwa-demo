<?php

declare(strict_types=1);

namespace App\PreloadGenerator;

use SpomkyLabs\PwaBundle\CachingStrategy\PreloadUrlsGeneratorInterface;
use SpomkyLabs\PwaBundle\Dto\Url;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class StaticPagesUrlPreloadGenerator implements PreloadUrlsGeneratorInterface
{
    /**
     * @var array<Url>|null
     */
    private null|array $urls = null;

    /**
     * @param array{string} $locales
     */
    public function __construct(
        #[Autowire('%kernel.enabled_locales%')]
        private readonly array $locales,
    ) {
    }

    public function getAlias(): string
    {
        return 'static_pages';
    }

    /**
     * @return iterable<Url>
     */
    public function generateUrls(): iterable
    {
        if ($this->urls === null) {
            foreach ($this->locales as $locale) {
                $this->urls[] = Url::create('app_homepage', [
                    '_locale' => $locale,
                ]);
            }
        }

        yield from $this->urls;
    }
}
