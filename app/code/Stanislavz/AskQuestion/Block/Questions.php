<?php

namespace Stanislavz\AskQuestion\Block;

use Magento\Framework\View\Element\Template;
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
     * AskQuestion constructor.
     * @param Template\Context $context
     * @param \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();

        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }
}
