<?php

namespace Stanislavz\SamplePaymentGateway\Block;

use Magento\Framework\Phrase;
use Magento\Payment\Block\ConfigurableInfo;
use Stanislavz\SamplePaymentGateway\Gateway\Response\FraudHandler;

/**
 * Class Info
 * @package Stanislavz\SamplePaymentGateway\Block
 */
class Info extends ConfigurableInfo
{
    /**
     * @param string $field
     * @return Phrase|string
     */
    protected function getLabel($field)
    {
        return __($field);
    }

    /**
     * @param string $field
     * @param string $value
     * @return Phrase|string
     */
    protected function getValueView($field, $value)
    {
        switch ($field) {
            case FraudHandler::FRAUD_MSG_LIST:
                return implode('; ', $value);
        }
        return parent::getValueView($field, $value);
    }

}
