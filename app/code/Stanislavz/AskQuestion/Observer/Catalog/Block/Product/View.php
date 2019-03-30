<?php

namespace Stanislavz\AskQuestion\Observer\Catalog\Block\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Customer\Model\Session;

/**
 * Class View
 * @package Stanislavz\AskQuestion\Observer\Catalog\Block\Product
 */
class View implements ObserverInterface
{
    /**
     * Layout handle name we need to add
     */
    public const LAYOUT_HANDLE = 'ask_question_tab';
    /**
     * @var Registry
     */
    private $registry;

    protected $customerSession;

    /**
     * View constructor.
     * @param Session $customerSession
     * @param Registry $registry
     */
    public function __construct(
        Session $customerSession,
        Registry $registry
    ) {
        $this->customerSession = $customerSession;
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $actionName = $observer->getEvent()->getData('full_action_name');

        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getEvent()->getData('layout');

        if ($actionName === 'catalog_product_view' && $this->getDisplayQuestionsCondition()) {
            $layout->getUpdate()->addHandle(static::LAYOUT_HANDLE);
        }

        return $this;
    }

    private function getDisplayQuestionsCondition()
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->registry->registry('current_product');
        $customerIsAllowedToDisplayQuestion = $this->customerSession->getCustomer()->getDisallowAskQuestion();

        $condition = $product && $product->getAllowQuestion() && !$customerIsAllowedToDisplayQuestion;

        return $condition;
    }

}
