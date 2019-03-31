<?php

namespace Stanislavz\AskQuestion\Observer\Catalog\Block\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\GroupRepositoryInterface;

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

    /** @var Session */
    private $customerSession;

    /** @var GroupRepositoryInterface */
    private $groupRepository;

    /**
     * View constructor.
     * @param GroupRepositoryInterface $groupRepository
     * @param Session $customerSession
     * @param Registry $registry
     */
    public function __construct(
        GroupRepositoryInterface $groupRepository,
        Session $customerSession,
        Registry $registry
    ) {
        $this->groupRepository = $groupRepository;
        $this->customerSession = $customerSession;
        $this->registry = $registry;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $actionName = $observer->getEvent()->getData('full_action_name');

        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getEvent()->getData('layout');

        if ($actionName === 'catalog_product_view'
            && $this->getCustomerCondition()
            && $this->getProductConditions()) {
            $layout->getUpdate()->addHandle(static::LAYOUT_HANDLE);
        }

        return $this;
    }

    /**
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCustomerCondition(): bool
    {
        $customer = $this->customerSession->getCustomer();
        $customerIsAllowedToDisplayQuestion = $customer->getDisallowAskQuestion();
        /** @var \Magento\Customer\Api\GroupRepositoryInterface groupRepository */
        $isAllowedCustomerGroupCode = $this->groupRepository
            ->getById($customer->getGroupId())
            ->getCode();

        $attributeCondition = !$customerIsAllowedToDisplayQuestion;
        $groupCondition = $isAllowedCustomerGroupCode !== \Stanislavz\AskQuestion\Setup\UpgradeData::DISALLOWED_QUESTION_CUSTOMER_GROUP;

        return $attributeCondition && $groupCondition;
    }

    /**
     * @return bool
     */
    private function getProductConditions(): bool
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->registry->registry('current_product');

        return $product && $product->getAllowQuestion();
    }

}
