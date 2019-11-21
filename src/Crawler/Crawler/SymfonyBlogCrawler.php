<?php declare(strict_types=1);

namespace App\Crawler\Crawler;

use App\Crawler\Page\BlogPostPage;
use App\Crawler\Page\BlogPostSearchPage;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymfonyBlogCrawler
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
     * @return BlogPostSearchPage
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getBlogPostSearchPage(string $url) : BlogPostSearchPage
    {
        $response = $this->httpClient->request('GET', $url);

        if (Response::HTTP_OK === $response->getStatusCode()) {
            $content = $response->getContent();
            $crawler = new Crawler($content, 'https://symfony.com');

            // Create an object to handle the target DOM elements
            return new BlogPostSearchPage($crawler);
        }

        throw new RuntimeException('Could not retrieve the blog posts.');
    }
}
