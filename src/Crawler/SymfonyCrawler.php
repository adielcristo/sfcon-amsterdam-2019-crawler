<?php declare(strict_types=1);

namespace App\Crawler;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class SymfonyCrawler
{
    /**
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getVersions() : array
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://symfony.com/versions.json');

        if (200 === $response->getStatusCode()) {
            return $response->toArray();
        }

        throw new RuntimeException('Could not retrieve the Symfony versions.');
    }

    /**
     * @return array
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getReleases() : array
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://symfony.com/releases.json');

        if (200 === $response->getStatusCode()) {
            return $response->toArray();
        }

        throw new RuntimeException('Could not retrieve the Symfony releases.');
    }
}
