<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class HomepageTest extends WebTestCase
{
    #[Test]
    public function theHomepageIsVisibleForEveryone(): void
    {
        //Given
        $client = static::createClient();

        //When
        $crawler = $client->request(Request::METHOD_GET, '/en');

        //Then
        static::assertGreaterThan(0, $crawler->filter('html:contains("app.name")')->count());
    }
}
