<?php

namespace Stanislavz\SamplePaymentGateway\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

class DescriptionDataBuilder implements BuilderInterface
{
    private static $description = 'description';

    /**
     * {@inheritDoc}
     */
    public function build(array $buildSubject): array
    {
        if (!isset($buildSubject['payment'])
            || !$buildSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }

        return [
            self::$description = 'platindeal-order'
        ];
    }

}