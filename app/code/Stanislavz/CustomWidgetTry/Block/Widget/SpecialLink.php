<?php
/**
 * Block for custom widget SpecialLink
 */

namespace Stanislavz\CustomWidgetTry\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class SpecialLink
 * @package Stanislavz\CustomWidgetTry\Block\Widget
 */
class SpecialLink extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/samplewidget.phtml";

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function outputBlock(): string
    {
        return $this->getLayout()
            ->createBlock('Magento\Cms\Block\Block')
            ->setBlockId($this->getBlockId())
            ->toHtml();
    }
}
