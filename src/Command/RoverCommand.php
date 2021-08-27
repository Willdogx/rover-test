<?php

declare(strict_types=1);

namespace App\Command;

use App\CommandQuestion\CreateMapCommandQuestion;
use App\CommandQuestion\MoveOrRotateRoverCommandQuestion;
use App\CommandQuestion\RoverPlacementCommandQuestion;
use App\Exception\ExitCommandException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RoverCommand extends Command
{
    protected static $defaultName = 'app:rover';

    public function __construct(
        private CreateMapCommandQuestion $createMapCommandQuestion,
        private RoverPlacementCommandQuestion $roverPlacementCommandQuestion,
        private MoveOrRotateRoverCommandQuestion $moveOrRotateCommandQuestion
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $questionHelper = $this->getHelper('question');
            $this->createMapCommandQuestion->askQuestion($questionHelper, $input, $output);

            while (true) {
                $this->roverPlacementCommandQuestion->askQuestion($questionHelper, $input, $output);
                $this->moveOrRotateCommandQuestion->askQuestion($questionHelper, $input, $output);
            }
        } catch (ExitCommandException) {
            $output->writeln('Goodbye!');
            return Command::SUCCESS;
        }
    }
}
