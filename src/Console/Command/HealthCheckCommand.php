<?php

declare(strict_types=1);

namespace PixelPerfect\HealthCheck\Console\Command;

use PixelPerfect\HealthCheck\Model\Result;
use PixelPerfect\HealthCheck\Model\Runner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HealthCheckCommand extends Command
{
    public function __construct(private readonly Runner $runner)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('pixelperfect:health:check')
            ->setDescription('Run registered health checks. Non-zero exit code on any failure.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $results = $this->runner->runAll();

        if (empty($results)) {
            $output->writeln('<comment>No health checks registered.</comment>');
            return Command::SUCCESS;
        }

        $hasFail = false;
        foreach ($results as $name => $result) {
            $tag = match ($result->getStatus()) {
                Result::STATUS_PASS => 'info',
                Result::STATUS_WARN => 'comment',
                Result::STATUS_FAIL => 'error',
                default              => 'comment',
            };
            $line = sprintf('[%s] %s', strtoupper($result->getStatus()), $name);
            if ($result->getMessage() !== '') {
                $line .= ': ' . $result->getMessage();
            }
            $output->writeln("<{$tag}>{$line}</{$tag}>");
            if ($result->isFail()) {
                $hasFail = true;
            }
        }

        return $hasFail ? Command::FAILURE : Command::SUCCESS;
    }
}
