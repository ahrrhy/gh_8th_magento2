<?php

namespace Stanislavz\AskQuestion\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;
use Stanislavz\AskQuestion\Model\AskQuestion;
use Magento\Framework\DB\Transaction;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Eav\Model\Config;

/**
 * Class UpgradeData
 * @package Stanislavz\AskQuestion\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Stanislavz\AskQuestion\Model\AskQuestionFactory
     */
    private $_askQuestionFactory;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $_transactionFactory;

    /** @var Config */
    private $eavConfig;

    /** @var Attribute */
    private $attributeResource;

    /**
     * UpgradeData constructor.
     * @param \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param Attribute $attributeResource
     * @param Config $eavConfig
     */
    public function __construct(
        \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
        Config $eavConfig
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_askQuestionFactory = $askQuestionFactory;
        $this->_transactionFactory = $transactionFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** Start setup */
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $statuses = [AskQuestion::STATUS_PENDING, AskQuestion::STATUS_ANSWERED];
            /** @var Transaction $transaction */
            $transaction = $this->_transactionFactory->create();

            for ($i = 1; $i <= 5; $i++) {
                /** @var AskQuestion $askQuestion */
                $askQuestion = $this->_askQuestionFactory->create();
                $askQuestion->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName('Stellar Solar Jacket')
                    ->setSku('WJ01')
                    ->setQuestion('Just a test question')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($askQuestion);
            }

            $transaction->save();
        }

        /** Add new product attribute */
        /** @var EavSetup $eavSetupFactory */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'allow_question',
            [
                'group' => 'General',
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'sort_order' => 50,
                'label' => 'Allow to ask questions',
                'input' => 'boolean',
                'class' => '',
                'source' => Boolean::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => Boolean::VALUE_YES,
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        /** @var EavSetup $eavSetupFactory */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            Customer::ENTITY,
            'disallow_ask_question',
            [
                'type'         => 'int',
                'label'        => 'Disallow Ask Question',
                'input'        => 'boolean',
                'required'     => true,
                'visible'      => true,
                'user_defined' => true,
                'sort_order' => 11,
                'position' => 11,
                'system' => 0,
                'source' => Boolean::class,
                'default' => Boolean::VALUE_NO
            ]
        );

        $attribute = $this->eavConfig->getAttribute(
            Customer::ENTITY,
            'disallow_ask_question'
        )->setData(
            [
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]
        );
        $this->attributeResource->save($attribute);

        /** End setup */
        $setup->endSetup();
    }
}
