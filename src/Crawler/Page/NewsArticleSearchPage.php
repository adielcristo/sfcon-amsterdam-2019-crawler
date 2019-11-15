<?php declare(strict_types=1);

namespace App\Crawler\Page;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

class NewsArticleSearchPage
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

    /**
     * @return int
     */
    public function getNewsArticlesTotal() : int
    {
        return (int) $this->crawler->filter('#updated-search-results-number')->text();
    }

    /**
     * @return Link[]
     */
    public function getNewsArticleLinks() : array
    {
        return $this->crawler->filter(
            'dl.searchResults div.contenttype-news-item a.state-published'
        )->links();
    }

    /**
     * @return Link
     */
    public function getNextSearchPageLink() : Link
    {
        return $this->crawler->filter('#search-results ul.paginacao.listingBar li a.proximo')->link();
    }
}
