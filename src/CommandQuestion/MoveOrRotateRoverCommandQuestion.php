<?php

declare(strict_types=1);

namespace App\CommandQuestion;

use App\Model\RoverRotateDirection;
use App\Service\RoverService;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class MoveOrRotateRoverCommandQuestion extends AbstractCommandQuestion
{
    public function __construct(private RoverService $roverService)
    {
    }

    protected function getQuestion(): Question
    {
        return new Question(sprintf('Move or rotate the rover:%s', PHP_EOL));
    }

    protected function validateAnswer(string $answer): void
    {
        if (!preg_match('/^(M|R|L)+$/', $answer, $matches)) {
            throw new RuntimeException('Input either `M` or `L` or `R`, like `MMRMLLMM`');
        }
    }

    protected function handleAnswer(string $answer, InputInterface $input, OutputInterface $output): void
    {
        foreach (str_split($answer) as $move) {
            $newRoverInfo = match ($move) {
                'M' => $this->roverService->moveRover(),
            default => $this->roverService->rotateRover(RoverRotateDirection::byValue($move))
            };
        }

        $output->writeln((string) $newRoverInfo);
    }
}
