<?php

namespace Stanislavz\LearnRoutes\Block;

class CustomLayout extends \Magento\Framework\View\Element\Template
{
    const JSON_RESPONSE = 'homework/jsonresponse/index';

    /**
     * @return string
     */
    public function getLinkToJson()
    {
        return $this->getUrl(self::JSON_RESPONSE);
    }
}
