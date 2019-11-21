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

class GetSymfonyBlogPostCommand extends Command
{
    protected static $defaultName = 'app:symfony:blog:post';

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
            ->setDescription('Get the blog post from URL.')
            ->setHelp('This command allows you to get the blog post for the given URL.')
            ->addArgument('url', InputArgument::REQUIRED, 'Blog post URL');
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
        $blogPost = $this->crawler->getBlogPost($url);

        $output->writeln('========== Post - Symfony Blog ==========');
        $output->writeln($blogPost->getTitle());
        $output->writeln($blogPost->getContent());
    }
}
