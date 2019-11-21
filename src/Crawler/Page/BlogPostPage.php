<?php declare(strict_types=1);

namespace App\Crawler\Page;

use DateTime;
use DateTimeZone;
use Symfony\Component\DomCrawler\Crawler;

class BlogPostPage
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function getTitle() : string
    {
        return $this->crawler->filter('div.container div.row main.col-sm-9 h1')->text();
    }

    public function getContent() : string
    {
        return $this->crawler->filter('div.container div.row main.col-sm-9 section div.post__content')->html();
    }

    public function getAuthor() : string
    {
        return $this->crawler->filter('div.container div.row main.col-sm-9 section p.metadata.m-b-15 span a')->text();
    }

    public function getPublishDate() : string
    {
        return $this->crawler->filter('div.container div.row main.col-sm-9 section p.metadata.m-b-15 span.m-r-15')->text();
    }
}
