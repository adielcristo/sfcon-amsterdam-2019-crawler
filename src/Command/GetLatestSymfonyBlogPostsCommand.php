<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\Crawler\SymfonyBlogCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetLatestSymfonyBlogPostsCommand extends Command
{
    protected static $defaultName = 'app:symfony:blog:latest';

    /**
     * @var SymfonyBlogCrawler
     */
    private $crawler;

    public function __construct(SymfonyBlogCrawler $crawler)
    {
        $this->crawler = $crawler;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setDescription('Get the latest posts from the Symfony Blog.')
            ->setHelp('This command allows you to get the latest posts from the Symfony Blog.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $searchPageUrl = 'https://symfony.com/blog/';
        $searchPage = $this->crawler->getBlogPostSearchPage($searchPageUrl);

        if (count($searchPage->getBlogPostLinks()) > 0) {
            $output->writeln('========== Latest Posts - Symfony Blog ==========');

            foreach ($searchPage->getBlogPostLinks() as $link) {
                $output->writeln($link->getUri());
            }
        }
    }
}
