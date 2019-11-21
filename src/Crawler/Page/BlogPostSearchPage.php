<?php declare(strict_types=1);

namespace App\Crawler\Page;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;

class BlogPostSearchPage
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
     * @return Link[]
     */
    public function getBlogPostLinks() : array
    {
        return $this->crawler->filter(
            'div.container div.post__excerpt h2.m-b-5 a'
        )->links();
    }

    /**
     * @return Link
     */
    public function hasNextSearchPageLink() : bool
    {
        return count($this->crawler->filter('div.container div.row main.col-sm-9 ul.pager li.text-right a')) > 0;
    }

    /**
     * @return Link
     */
    public function getNextSearchPageLink() : Link
    {
        return $this->crawler->filter('div.container div.row main.col-sm-9 ul.pager li.text-right a')->link();
    }
}
