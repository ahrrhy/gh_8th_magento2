<?php

namespace Stanislavz\AskQuestion\Cron;

use Stanislavz\AskQuestion\Model\ChangeStatus;

/**
 * Class QuestionStatus
 * @package Stanislavz\AskQuestion\Cron
 */
class QuestionStatus
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    private $statusModel;

    /**
     * Example constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ChangeStatus $statusModel
    ) {
        $this->logger      = $logger;
        $this->statusModel = $statusModel;
    }

    /**
     * This will change status of questions
     */
    public function execute()
    {
        $this->statusModel->changeQuestionStatus(
            \Stanislavz\AskQuestion\Model\AskQuestion::STATUS_ANSWERED,
            $this->getDays()
        );
        $this->logger->info('Cron Works');
    }

    /**
     * @return int
     */
    private function getDays(): int
    {
        // Todo create admin menu config and get days from there
        return 3;
    }
}
