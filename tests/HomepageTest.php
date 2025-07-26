<?php

declare(strict_types=1);

namespace App\Tests;

use Ergebnis\PHPUnit\SlowTestDetector\Attribute\MaximumDuration;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageTest extends WebTestCase
{
    #[Test]
    #[MaximumDuration(2000)]
    public function theRootControllerRedirectsToTheUserLocale(): void
    {
        //Given
        $client = static::createClient();

        //When
        $crawler = $client->request('GET', '/');

        //Then
        self::assertResponseRedirects('/en_US');
    }

    #[Test]
    public function theHomepageIsVisibleForEveryone(): void
    {
        //Given
        $client = static::createClient();

        //When
        $crawler = $client->request('GET', '/en_US');

        //Then
        static::assertGreaterThan(0, $crawler->filter('html:contains("app.name")')->count());
    }
}
