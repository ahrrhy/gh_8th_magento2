<?php

namespace Darkwoolf\Person\Controller\Person;

use Magento\Framework\Controller\ResultFactory;

class IndexPage extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $firstname = 'Dark';
        $lastname = "Woolf";
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getLayout()
            ->getBlock('custom.person.page.result')->setFullName($firstname . ' ' . $lastname);
        return $resultPage;
    }
}
