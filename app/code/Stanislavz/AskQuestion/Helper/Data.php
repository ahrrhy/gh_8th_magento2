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
    public const XML_PATH_STANISLAVZ_CRON_ENABLE = 'stanislavz_cron_options/cron/enable';

    public const XML_PATH_STANISLAVZ_CRON_DAYS = 'stanislavz_cron_options/cron/days';

    public const XML_PATH_STANISLAVZ_EMAIL_ENABLE = 'stanislavz_crone_options/email/enable';

    public const XML_PATH_STANISLAVZ_EMAIL_ADMIN_EMAIL = 'stanislavz_crone_options/email/admin_email';

    public const GENERAL_STORE_CONTACT_EMAIL = 'trans_email/ident_general/email';

    public const GENERAL_STORE_CONTACT_NAME = 'trans_email/ident_general/name';

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

    /**
     * @param null $storeId
     * @return string
     */
    public function getStoreName($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::GENERAL_STORE_CONTACT_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getStoreEmail($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::GENERAL_STORE_CONTACT_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return int
     */
    public function getAdminEmailEnableNotification($storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_EMAIL_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param null $storeId
     * @return string
     */
    public function getAdminEmailAddress($storeId = null): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_STANISLAVZ_EMAIL_ADMIN_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

}
