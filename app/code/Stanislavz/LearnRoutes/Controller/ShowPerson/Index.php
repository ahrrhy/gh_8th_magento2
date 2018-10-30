<?php

namespace Stanislavz\LearnRoutes\Controller\ShowPerson;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $name     = 'Stanislav';
        $lastName = 'Zhuravel';
        $this->_view->loadLayout()
            ->getLayout()
            ->getBlock('learnroutes.block')
            ->setName($name)->setLastName($lastName);
        $this->_view->renderLayout();
    }
}
