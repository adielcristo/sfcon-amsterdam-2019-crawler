<?php declare(strict_types=1);

namespace App\Crawler;

use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymfonyCrawler
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

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
        $response = $this->httpClient->request('GET', 'https://symfony.com/versions.json');

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
