<?php declare(strict_types=1);

namespace App\Crawler\Page;

use DateTime;
use DateTimeZone;
use Symfony\Component\DomCrawler\Crawler;

class NewsArticlePage
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
        return $this->crawler->filter('div div#content article header h1')->text();
    }

    public function getDescription() : string
    {
        return $this->crawler->filter('div div#content article header h2')->text();
    }

    public function getContent() : string
    {
        return $this->crawler->filter('div div#content article div.contentBody')->html();
    }

    public function getAuthor() : string
    {
        return $this->crawler->filter('div div#content article header div.noticias_media div.autor strong')->text();
    }

    public function getPublishDate() : DateTime
    {
        $time = $this->crawler->filter('div div#content article header div.noticias_media time')->text();

        return $this->getDateTime($time);
    }

    private function getDateTime(string $time) : DateTime
    {
        $timezone = new DateTimeZone('America/Sao_Paulo');

        return DateTime::createFromFormat('Y-m-d H:i', $time, $timezone);
    }
}
