<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RoverCommandTest extends KernelTestCase
{
    public function testCommandOutput(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:rover');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs(['5 5', '1 2 N', 'LMLMLMLMM', '3 3 E', 'MMRMMRMRRM', 'exit']);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $questionsAndOutput = explode(PHP_EOL, $output);

        $this->assertEquals('input the max x and y coordinates for the map (x y):', $questionsAndOutput[0]);
        $this->assertEquals('choose the rover placement (x y direction -> 1 1 N):', $questionsAndOutput[1]);
        $this->assertEquals('Move or rotate the rover:', $questionsAndOutput[2]);
        $this->assertEquals('1 3 N', $questionsAndOutput[3]);
        $this->assertEquals('choose the rover placement (x y direction -> 1 1 N):', $questionsAndOutput[4]);
        $this->assertEquals('Move or rotate the rover:', $questionsAndOutput[5]);
        $this->assertEquals('5 1 E', $questionsAndOutput[6]);
        $this->assertEquals('choose the rover placement (x y direction -> 1 1 N):', $questionsAndOutput[7]);
        $this->assertEquals('Goodbye!', $questionsAndOutput[8]);
    }
}
