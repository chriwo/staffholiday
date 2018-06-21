<?php
namespace ChriWo\Staffholiday\Utility;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility as LocalizationUtilityExtbase;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class LocalizationUtility.
 */
class LocalizationUtility extends LocalizationUtilityExtbase
{
    /**
     * Returns the localized label of the LOCAL_LANG key, but prefill extensionName.
     *
     * @param string $key the key from the LOCAL_LANG array for which to return the value
     * @param string $extensionName The name of the extension
     * @param array $arguments the arguments of the extension, being passed over to vsprintf
     * @return string|null
     */
    public static function translate($key, $extensionName = 'staffholiday', $arguments = null)
    {
        return parent::translate($key, $extensionName, $arguments);
    }

    /**
     * Get locallang translation with key prefix tx_staffholiday_domain_model_log.state.
     *
     * @param int $state
     * @return null|string
     */
    public static function translateByState($state)
    {
        return self::translate('tx_staffholiday_domain_model_log.state.' . $state);
    }

    /**
     * Get the correct format of a date.
     *
     * @return null|string
     */
    public static function translateByConfiguration()
    {
        $configuration = EmConfigurationUtility::getSettings();

        return self::translate('format-' . $configuration->getDateTimeHoliday());
    }
}
