<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\Crawler\CityHallNewsCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetLatestCityHallNewsCommand extends Command
{
    protected static $defaultName = 'app:news:latest';
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
            ->setDescription('Get the latest news from the São Paulo City Hall.')
            ->setHelp('This command allows you to get the latest news from the São Paulo City Hall.');
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
        $searchPageUrl = 'http://www.capital.sp.gov.br/@@busca_atualizada?pt_toggle=%23&b_start:int=0&portal_type:list=News%20Item';
        $searchPage = $this->crawler->getNewsArticleSearchPage($searchPageUrl);

        if ($searchPage->getNewsArticlesTotal() > 0) {
            $output->writeln('========== Latest News - São Paulo City Hall ==========');

            foreach ($searchPage->getNewsArticleLinks() as $link) {
                $output->writeln($link->getUri());
            }
        }
    }
}
