<?php

declare(strict_types=1);

namespace App\CommandQuestion;

use App\Exception\ExitCommandException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

abstract class AbstractCommandQuestion
{
    public function askQuestion(QuestionHelper $questionHelper, InputInterface $input, OutputInterface $output): void
    {
        $question = $this->getQuestion();
        $question->setValidator(function (string $answer) {
            if ($answer === 'exit') {
                return $answer;
            }

            $this->validateAnswer($answer);
            return $answer;
        });
        $answer = $questionHelper->ask($input, $output, $question);

        if ($answer === 'exit') {
            throw new ExitCommandException();
        }

        $this->handleAnswer($answer, $input, $output);
    }

    abstract protected function getQuestion(): Question;
    abstract protected function validateAnswer(string $answer): void;
    abstract protected function handleAnswer(string $answer, InputInterface $input, OutputInterface $output): void;
}
