<?php

namespace Stanislavz\AskQuestion\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Stanislavz\AskQuestion\Helper
 */
class Data extends AbstractHelper
{
    public const XML_PATH_STANISLAVZ_CRON_ENABLE = 'stanislavz_crone_options/cron/enable';

    public const XML_PATH_STANISLAVZ_CRON_DAYS = 'stanislavz_crone_options/cron/days';

    /**
     * @param null $storeId
     * @return int|bool
     */
    public function getConfigValueEnableCron($storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_CRON_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function getConfigValueDays($storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_CRON_DAYS,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
