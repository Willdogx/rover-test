<?php

declare(strict_types=1);

namespace App\CommandQuestion;

use App\Model\RoverDirection;
use App\Service\RoverService;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class RoverPlacementCommandQuestion extends AbstractCommandQuestion
{
    public function __construct(private RoverService $roverService)
    {
    }

    protected function getQuestion(): Question
    {
        return new Question(sprintf('choose the rover placement (x y direction -> 1 1 N):%s', PHP_EOL));
    }

    protected function validateAnswer(string $answer): void
    {
        if (!preg_match('/^\d+ \d+ (N|E|S|W)$/', $answer, $matches)) {
            throw new RuntimeException('Input must be 2 numbers separated by a space and a cardinal direction, like `5 5 N`');
        }
    }

    protected function handleAnswer(string $answer, InputInterface $input, OutputInterface $output): void
    {
        [$x, $y, $direction] = explode(' ', $answer);

        $this->roverService->placeRover((int) $x, (int) $y, RoverDirection::byValue($direction));
    }
}
