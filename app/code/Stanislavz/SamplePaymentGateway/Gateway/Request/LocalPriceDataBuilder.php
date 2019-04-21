<?php

namespace Stanislavz\SamplePaymentGateway\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

class LocalPriceDataBuilder implements BuilderInterface
{
    private static $localPrice = 'localPrice';

    private static $currency = 'currency';

    private static $amount = 'amount';

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject): array
    {
        if (!isset($buildSubject['payment'])
            || !$buildSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }
        /** @var PaymentDataObjectInterface $payment */
        $payment = $buildSubject['payment'];
        /** @var \Magento\Payment\Gateway\Data\Order\OrderAdapter $order */
        $order = $payment->getOrder();

        return [
            self::$localPrice => [
                self::$currency => $order->getCurrencyCode(),
                self::$amount => $order->getGrandTotalAmount()
            ]
        ];
    }

}
