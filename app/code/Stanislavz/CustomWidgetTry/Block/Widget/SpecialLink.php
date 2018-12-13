<?php

namespace Stanislavz\CustomWidgetTry\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class SpecialLink extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/samplewidget.phtml";
}
