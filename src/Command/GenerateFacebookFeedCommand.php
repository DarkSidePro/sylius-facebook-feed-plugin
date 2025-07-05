<?php

declare(strict_types=1);

namespace DarkSidePro\SyliusFacebookFeedPlugin\Command;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use DarkSidePro\SyliusFacebookFeedPlugin\Services\FeedGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateFacebookFeedCommand extends Command
{
    protected static $defaultName = 'app:facebook-feed:generate';

    public function __construct(
        private FeedGeneratorInterface $feedGenerator,
        private ChannelContextInterface $channelContext
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('output', InputArgument::REQUIRED, 'Output file path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $channel = $this->channelContext->getChannel();
        $feedContent = $this->feedGenerator->generate($channel);
        
        file_put_contents($input->getArgument('output'), $feedContent);
        
        return Command::SUCCESS;
    }
}