<?php declare(strict_types=1);

namespace App\Crawler\Crawler;

use App\Crawler\Page\NewsArticlePage;
use App\Crawler\Page\NewsArticleSearchPage;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CityHallNewsCrawler
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
     * @param string $url
     * @return NewsArticleSearchPage
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getNewsArticleSearchPage(string $url) : NewsArticleSearchPage
    {
        $response = $this->httpClient->request('GET', $url);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $content = $response->getContent();
            $crawler = new Crawler($content);

            // Create an object to handle the target DOM elements
            return new NewsArticleSearchPage($crawler);
        }

        throw new RuntimeException('Could not retrieve the news articles.');
    }

    /**
     * @param string $url
     * @return NewsArticlePage
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getNewsArticle(string $url) : NewsArticlePage
    {
        $response = $this->httpClient->request('GET', $url);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $content = $response->getContent();
            $crawler = new Crawler($content);

            // Create an object to handle the target DOM elements
            return new NewsArticlePage($crawler);
        }

        throw new RuntimeException('Could not retrieve the news article.');
    }
}
