<?php

namespace Stanislavz\LearnRoutes\Controller\JsonResponse;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** var \Magento\Framework\Result\Json $controllerResult */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['content' => "https://inchoo.net/magento-2/routing-in-magento-2/"];

        return $controllerResult->setData($data);
    }
}
