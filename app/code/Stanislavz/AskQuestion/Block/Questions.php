<?php

namespace Stanislavz\AskQuestion\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\SessionFactory;
use Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\Collection;

/**
 * Class AskQuestion
 * @package Stanislavz\AskQuestion\Block
 */
class Questions extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /** @var SessionFactory */
    protected $customerSessionFactory;

    /**
     * Questions constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->_coreRegistry = $registry;
        $this->customerSessionFactory = $customerSessionFactory;
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductName()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getName() : null;
    }

    /**
     * @return Collection
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }
        $collection->addFieldToFilter('product_name', $this->getProductName())
            ->load();
        return $collection;
    }

    /**
     * @return Collection
     */
    public function getQuestionsHistory()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        if ($limit = $this->getData('questions_history_limit')) {
            $collection->setPageSize($limit);
        }
        $collection->addFieldToFilter('email', [$this->getCustomerEmail()])
            ->load();
        return $collection;
    }

    /**
     * @return string
     */
    private function getCustomerEmail(): string
    {
        /** @var \Magento\Customer\Model\Session $customerSession */
        $customerSession = $this->customerSessionFactory->create();

        return $customerSession->getCustomer()->getEmail();
    }
}
