<?php

namespace Stanislavz\AskQuestion\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;
use Stanislavz\AskQuestion\Model\AskQuestion;
use Magento\Framework\DB\Transaction;

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
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $_transactionFactory;

    /**
     * UpgradeData constructor.
     * @param \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory
     */
    public function __construct(
        \Stanislavz\AskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->_askQuestionFactory = $askQuestionFactory;
        $this->_transactionFactory = $transactionFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
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
        $setup->endSetup();
    }
}
