<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\Crawler\SymfonyBlogCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetAllSymfonyBlogPostsCommand extends Command
{
    protected static $defaultName = 'app:symfony:blog:all';

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
            ->setDescription('Get all posts from the Symfony Blog.')
            ->setHelp('This command allows you to get all posts from the Symfony Blog.')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Number of search pages to retrieve', 3);
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
        $limit = $input->getArgument('limit');
        $searchPageUrl = 'https://symfony.com/blog/';
        $searchPage = $this->crawler->getBlogPostSearchPage($searchPageUrl);

        $output->writeln('========== All Posts - Symfony Blog ==========');

        foreach ($searchPage->getBlogPostLinks() as $link) {
            $output->writeln($link->getUri());
        }

        while ($searchPage->hasNextSearchPageLink() && $limit-- > 0) {
            $nextPageUrl = $searchPage->getNextSearchPageLink()->getUri();
            $nextSearchPage = $this->crawler->getBlogPostSearchPage($nextPageUrl);

            foreach ($nextSearchPage->getBlogPostLinks() as $link) {
                $output->writeln($link->getUri());
            }

            $searchPage = $nextSearchPage;
        }
    }
}
