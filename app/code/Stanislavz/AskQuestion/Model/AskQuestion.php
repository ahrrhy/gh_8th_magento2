<?php

namespace Stanislavz\AskQuestion\Model;

use Stanislavz\AskQuestion\Model\ResourceModel\AskQuestion as AskQuestionResource;

/**
 * Class AskQuestion
 * @package Stanislavz\AskQuestion\Model
 *
 * @method int|string getQuestionId()
 * @method int|string getName()
 * @method AskQuestion setName(string $name)
 * @method string getEmail()
 * @method AskQuestion setEmail(string $email)
 * @method string getPhone()
 * @method AskQuestion setPhone(string $phone)
 * @method string getProductName()
 * @method AskQuestion setProductName(string $productName)
 * @method string getSku()
 * @method AskQuestion setSku(string $sku)
 * @method string getQuestion()
 * @method AskQuestion setQuestion(string $request)
 * @method string getCreatedAt()
 * @method string getStatus()
 * @method AskQuestion setStatus(string $status)
 * @method int|string getStoreId()
 * @method AskQuestion setStoreId(int $storeId)
 */
class AskQuestion extends \Magento\Framework\Model\AbstractModel
{
    /**
     * This is available question statuses
     */
    const STATUS_PENDING = 'pending';
    const STATUS_READ = 'read';
    const STATUS_ANSWERED = 'answered';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * AskQuestion constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(AskQuestionResource::class);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSave(): \Magento\Framework\Model\AbstractModel
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }
        if (!$this->getStoreId()) {
            $this->setStoreId($this->_storeManager->getStore()->getId());
        }

        return parent::beforeSave();
    }
}
