<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\Crawler\SymfonyCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetSymfonyVersionsCommand extends Command
{
    protected static $defaultName = 'app:symfony:versions';

    /**
     * @var SymfonyCrawler
     */
    private $crawler;

    public function __construct(SymfonyCrawler $crawler)
    {
        $this->crawler = $crawler;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this
            ->setDescription('Get information about the Symfony versions.')
            ->setHelp('This command allows you to get information about the Symfony versions.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $versions = $this->crawler->getVersions();

        if (!empty($versions)) {
            $output->writeln('========== Symfony Versions ==========');

            foreach ($versions as $key => $version) {
                // Skipping some keys because there are a lot of versions
                if ($key === 'non_installable' || $key === 'installable') {
                    continue;
                }

                $output->writeln(sprintf('%s: %s', $key, $version));
            }
        }
    }
}
