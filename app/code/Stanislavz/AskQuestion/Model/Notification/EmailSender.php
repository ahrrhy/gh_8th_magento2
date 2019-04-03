<?php

namespace Stanislavz\AskQuestion\Model\Notification;

use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;
use Stanislavz\AskQuestion\Helper\Data;

class EmailSender
{
    public const ADMIN_ASKQUESTION_EMAIL_TEMPLATE    = 'admin_question_notification';

    public const CUSTOMER_ASKQUESTION_EMAIL_TEMPLATE = 'customer_question_notification';

    /** @var TransportBuilder */
    protected $transportBuilder;

    /** @var StateInterface */
    protected $inlineTranslation;

    /** @var LoggerInterface */
    protected $logger;

    /** @var Data */
    protected $helperData;

    /**
     * EmailSender constructor.
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param LoggerInterface $logger
     * @param Data $helperData
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        LoggerInterface $logger,
        Data $helperData
    ) {
        $this->transportBuilder  = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->helperData = $helperData;
        $this->logger = $logger;
    }

    /**
     * @param $receiverData
     * @param $emailTemplateID
     * @param null $adminEmailAddress
     */
    public function sendNotification($receiverData, $emailTemplateID, $adminEmailAddress = null): void
    {
        $sender = [
            'name' => $this->helperData->getStoreName(),
            'email' => $this->helperData->getStoreEmail(),
        ];

        $templateOptions = [
            'area' => Area::AREA_FRONTEND,
            'store' => Store::DEFAULT_STORE_ID,
        ];

        $templateVars = $receiverData;

        $addTo = $this->getAddTo($receiverData, $adminEmailAddress);

        if ($adminEmailAddress !== null) {
            $templateVars['vars']['isForAdmin'] = true;
        }

        try {
            $this->inlineTranslation->suspend();
            $transport = $this->transportBuilder->setTemplateIdentifier(
                $emailTemplateID
            )->setTemplateOptions(
                $templateOptions
            )->setTemplateVars(
                $templateVars
            )->setFrom(
                $sender
            )->addTo(
                $addTo
            )->getTransport();
            $transport->sendMessage();

        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->logger->error($e);
            return;
        }
    }

    /**
     * @param $receiverData
     * @param null $adminEmailAddress
     * @return array
     */
    private function getAddTo($receiverData, $adminEmailAddress = null): array
    {
        $addTo = [];
        if ($adminEmailAddress !== null) {
            $addTo['name']  = 'Admin';
            $addTo['email'] = $adminEmailAddress;
        } else {
            $addTo['name']  = $receiverData['name'];
            $addTo['email'] = $receiverData['email'];
        }

        return $addTo;
    }
}