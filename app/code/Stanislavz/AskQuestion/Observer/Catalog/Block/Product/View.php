<?php

namespace Stanislavz\AskQuestion\Observer\Catalog\Block\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;

/**
 * Class View
 * @package Stanislavz\AskQuestion\Observer\Catalog\Block\Product
 */
class View implements ObserverInterface
{
    public const LAYOUT_HANDLE = 'ask_question_tab';
    /**
     * @var Registry
     */
    private $registry;

    /**
     * Predispatch constructor.
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $actionName = $event->getData('full_action_name');
        $product = $this->registry->registry('current_product');
        $layout = $event->getData('layout');

        if ($product && $actionName === 'catalog_product_view' && $product->getAllowQuestion()) {
            $layout->getUpdate()->addHandle(static::LAYOUT_HANDLE);
        }

        return $this;
    }
}
