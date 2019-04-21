<?php

namespace Stanislavz\SamplePaymentGateway\Gateway\Request;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Gateway\Data\Order\OrderAdapter;

class MetadataDataBuilder
{
    private static $metadata = 'metadata';

    private static $order = 'order';

    private static $items = 'items';

    private static $incrementId = 'incrementId';
    /**
     * {@inheritDoc}
     */
    public function build(array $buildSubject)
    {
        if (!isset($buildSubject['payment'])
            || !$buildSubject['payment'] instanceof PaymentDataObjectInterface
        ) {
            throw new \InvalidArgumentException('Payment data object should be provided');
        }
        /** @var PaymentDataObjectInterface $payment */
        $payment = $buildSubject['payment'];
        /** @var OrderAdapter $order */
        $order = $payment->getOrder();

        return [
            self::$metadata => $this->formOrderData($order)
        ];
    }

    /**
     * @param OrderAdapter $order
     * @return array
     */
    private function formOrderData($order): array
    {
        return [
            self::$order => $this->getOrderData($order),
            self::$items => $this->getOrderItemsData($order)
        ];
    }

    /**
     * @param OrderAdapter $order
     * @return array
     */
    private function getOrderItemsData($order): array
    {
        /** @var \Magento\Sales\Model\Order\Item $items */
        $items = $order->getItems();
        $itemsData = [];

        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($items as $item) {
            $itemsData[][] = [
                'productName' => $item->getName(),
                'productSku' => $item->getSku(),
                'productId' => $item->getId(),
                'productType' => $item->getProductType(),
                'productPrice' => $item->getProductPriced()
            ];
        }

        return $itemsData;
    }

    /**
     * @param OrderAdapter $order
     * @return array
     */
    private function getOrderData($order): array
    {
        return [
            self::$incrementId => $order->getOrderIncrementId()
        ];
    }

}
