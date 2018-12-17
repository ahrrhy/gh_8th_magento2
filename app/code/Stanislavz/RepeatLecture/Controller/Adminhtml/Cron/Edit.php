<?php

namespace Stanislavz\RepeatLecture\Controller\Adminhtml\Cron;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 * @package Stanislavz\RepeatLecture\Controller\Adminhtml\Cron
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Cron Job'));
        return $resultPage;
    }
}
