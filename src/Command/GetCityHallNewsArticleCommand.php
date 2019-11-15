<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\Crawler\CityHallNewsCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetCityHallNewsArticleCommand extends Command
{
    protected static $defaultName = 'app:news:article';

    /**
     * @var CityHallNewsCrawler
     */
    private $crawler;

    public function __construct(CityHallNewsCrawler $crawler)
    {
        $this->crawler = $crawler;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setDescription('Get the news article from URL.')
            ->setHelp('This command allows you to get the news article for the given URL.')
            ->addArgument('url', InputArgument::REQUIRED, 'News article URL');
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
        $url = $input->getArgument('url');
        $newsArticle = $this->crawler->getNewsArticle($url);

        $output->writeln('========== News Article - São Paulo City Hall ==========');
        $output->writeln($newsArticle->getTitle());
        $output->writeln($newsArticle->getContent());
    }
}
