<?php

namespace Stanislavz\SamplePaymentGateway\Gateway\Http\Client;

use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Model\Method\Logger;

/**
 * Class ClientMock
 * @package Stanislavz\SamplePaymentGateway\Gateway\Http\Client
 */
class ClientMock implements ClientInterface
{
    public const SUCCESS = 1;
    public const FAILURE = 0;

    /**
     * @var array
     */
    private $results = [
        self::SUCCESS,
        self::FAILURE
    ];

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(
        Logger $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param TransferInterface $transferObject
     * @return array
     * @throws \Exception
     */
    public function placeRequest(TransferInterface $transferObject): array
    {
        $response = $this->generateResponseForCode(
            $this->getResultCode(
                $transferObject
            )
        );
        $this->logger->debug(
            [
                'request' => $transferObject->getBody(),
                'response' => $response
            ]
        );

        return $response;
    }

    /**
     * @param $resultCode
     * @return array
     * @throws \Exception
     */
    protected function generateResponseForCode($resultCode): array
    {
        return array_merge(
            [
                'RESULT_CODE' => $resultCode,
                'TXN_ID' => $this->generateTxnId()
            ],
            $this->getFieldsBasedOnResponseType($resultCode)
        );
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function generateTxnId(): string
    {
        return md5(random_int(0, 1000));
    }

    /**
     * @param TransferInterface $transfer
     * @return int
     */
    private function getResultCode(TransferInterface $transfer): int
    {
        $headers = $transfer->getHeaders();
        if (isset($headers['force_result'])) {
            return (int)$headers['force_result'];
        }

        return $this->results[mt_rand(0, 1)];
    }

    /**
     * @param $resultCode
     * @return array
     */
    private function getFieldsBasedOnResponseType($resultCode): array
    {
        switch ($resultCode) {
            case self::FAILURE:
                return [
                    'FRAUD_MSG_LIST' => [
                        'Stolen card',
                        'Customer location differs'
                    ]
                ];
        }

        return [];
    }
}
