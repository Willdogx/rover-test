<?php

declare(strict_types=1);

namespace App\CommandQuestion;

use App\Service\RoverService;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateMapCommandQuestion extends AbstractCommandQuestion
{
    public function __construct(private RoverService $roverService)
    {
    }

    protected function handleAnswer(string $answer, InputInterface $input, OutputInterface $output): void
    {
        [$x, $y] = explode(' ', $answer);

        $this->roverService->initMap((int) $x, (int) $y);
    }

    protected function validateAnswer(string $answer): void
    {
        if (!preg_match('/^\d+ \d+$/', $answer, $matches)) {
            throw new RuntimeException('Coordinates must be 2 numbers separated by a space, like `5 5`');
        }
    }

    protected function getQuestion(): Question
    {
        return new Question(sprintf('input the max x and y coordinates for the map (x y):%s', PHP_EOL));
    }
}
