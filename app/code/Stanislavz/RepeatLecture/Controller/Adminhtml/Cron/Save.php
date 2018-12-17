<?php

namespace Stanislavz\RepeatLecture\Controller\Adminhtml\Cron;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Save
 * @package Stanislavz\RepeatLecture\Controller\Adminhtml\Cron
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** Get data from request */
        $requestData = $this->getRequest()->getPostValue();

        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/index');
    }
}
