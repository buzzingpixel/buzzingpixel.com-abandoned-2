<?php
declare(strict_types=1);

namespace src\app\cli\factories;

use Symfony\Component\Console\Question\Question;

/**
 * Class ConsoleQuestionFactory
 */
class ConsoleQuestionFactory
{
    /**
     * Gets a Question instance
     * @param string $question
     * @return Question
     */
    public function make(string $question): Question
    {
        return new Question($question);
    }
}
