<?php

namespace Stanislavz\SamplePaymentGateway\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Framework\UrlInterface;

class UrlDataBuilder implements BuilderInterface
{
    /** @var UrlInterface */
    protected $urlInterface;

    private static $successUrl = 'successUrl';

    private static $cancelUrl = 'cancelUrl';

    private static $ipnUrl = 'ipnUrl';

    /**
     * UrlDataBuilder constructor.
     * @param UrlInterface $urlInterface
     */
    public function __construct(UrlInterface $urlInterface)
    {
        $this->urlInterface = $urlInterface;
    }

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
            self::$successUrl => $this->urlInterface->getUrl('samplepaymentgateway/success/index'),
            self::$cancelUrl => $this->urlInterface->getUrl('samplepaymentgateway/cancel/index'),
            self::$ipnUrl => $this->urlInterface->getUrl('samplepaymentgateway/ipn/index')
        ];
    }

}
