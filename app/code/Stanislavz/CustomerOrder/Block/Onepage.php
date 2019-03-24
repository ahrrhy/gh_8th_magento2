<?php

namespace Stanislavz\CustomerOrder\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class Onepage
 * @package Stanislavz\CustomerOrder\Block
 */
class Onepage extends Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['onepageScope']['children']['steps']
        ['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('customerorder/customer/getList');
        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}