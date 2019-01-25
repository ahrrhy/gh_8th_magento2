<?php

namespace Stanislavz\AskQuestion\Model\ResourceModel;

/**
 * Class AskQuestion
 * @package Stanislavz\AskQuestion\Model\ResourceModel
 */
class AskQuestion extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('stanislavz_ask_question', 'question_id');
    }
}
