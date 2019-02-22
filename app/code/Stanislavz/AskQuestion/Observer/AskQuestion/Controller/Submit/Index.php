<?php

namespace Stanislavz\AskQuestion\Observer\AskQuestion\Controller\Submit;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Stanislavz\AskQuestion\Helper\Data as ScopeHelperData;

/**
 * Class Index
 * @package Stanislavz\AskQuestion\Observer\AskQuestion\Controller\Submit
 */
class Index implements ObserverInterface
{
    private $dataHelper;

    public function __construct(ScopeHelperData $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        if (!$this->isEmailNotificationEnabled()) {
            return;
        }
        /** @var \Magento\Framework\Event $event */
        $event = $observer->getEvent();
        /** @var \Magento\Framework\App\Request\Http $request */
        $request = $event->getData('request');
        $customerEmail = $request->getPost('email');
        return $this;
    }

    /**
     * @return string
     */
    private function getAdminEmail(): string
    {
        return $this->dataHelper->getAdminEmailAddress();
    }

    /**
     * @return int
     */
    private function isEmailNotificationEnabled(): int
    {
        return $this->dataHelper->getAdminEmailEnableNotification();
    }

    private function sendEmail()
    {

    }
}
