<?php declare(strict_types=1);

namespace App\Command;

use App\Crawler\SymfonyCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetSymfonyReleasesCommand extends Command
{
    protected static $defaultName = 'app:symfony:releases';

    protected function configure() : void
    {
        $this
            ->setDescription('Get information about the Symfony releases.')
            ->setHelp('This command allows you to get information about the Symfony releases.');
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
        $crawler = new SymfonyCrawler();
        $releases = $crawler->getReleases();

        if (!empty($releases)) {
            $output->writeln('========== Symfony Releases ==========');
            $output->writeln(sprintf('LTS: %s', $releases['symfony_versions']['lts']));
            $output->writeln(sprintf('Stable: %s', $releases['symfony_versions']['stable']));
            $output->writeln(sprintf('Next: %s', $releases['symfony_versions']['next']));
            $output->writeln(sprintf('Latest Stable Version: %s', $releases['latest_stable_version']));
            $output->writeln('Supported Versions:');

            foreach ($releases['supported_versions'] as $version) {
                $output->writeln($version);
            }
        }
    }
}
