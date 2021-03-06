<?php

namespace Stanislavz\AskQuestion\Cron;

use Stanislavz\AskQuestion\Model\ChangeStatus;
use Stanislavz\AskQuestion\Model\AskQuestion;
use Stanislavz\AskQuestion\Helper\Data;

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

    /**
     * @var ChangeStatus
     */
    private $statusModel;

    /**
     * @var Data
     */
    private $helperData;

    /**
     * QuestionStatus constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param ChangeStatus $statusModel
     * @param Data $helperData
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ChangeStatus $statusModel,
        Data $helperData
    ) {
        $this->logger      = $logger;
        $this->statusModel = $statusModel;
        $this->helperData  = $helperData;
    }

    /**
     * This will change status of questions
     */
    public function execute(): void
    {
        if (!$this->checkEnabled()) {
            return;
        }

        $this->statusModel->changeQuestionStatus(
            AskQuestion::STATUS_ANSWERED,
            $this->getDays()
        );
        $this->logger->info('Cron Works');
    }

    /**
     * @return int
     */
    private function getDays(): int
    {
        return $this->helperData->getConfigValueDays();
    }

    /**
     * @return bool|int
     */
    private function checkEnabled()
    {
        return $this->helperData->getConfigValueEnableCron();
    }
}
