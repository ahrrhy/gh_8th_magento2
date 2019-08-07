<?php

namespace Darkwoolf\Person\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{
    const LINK_TO_JSON = 'home-work/jsonresponse/index';
    /**
     * @return string
     */
    public function getLinkToJson()
    {
        return $this->getUrl(self::LINK_TO_JSON);
    }
}
