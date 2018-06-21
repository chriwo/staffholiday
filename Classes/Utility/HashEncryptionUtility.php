<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Model\Plan;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Exception;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class HashEnryptionUtility.
 */
class HashEncryptionUtility extends AbstractUtility
{
    /**
     * Check if given hash is correct.
     *
     * @param string $hash
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @throws \Exception
     * @return bool
     */
    public static function validPlanHash($hash, Plan $plan)
    {
        return self::createHashForPlan($plan) === $hash;
    }

    /**
     * Create hash for a comment.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @throws \Exception
     * @return string
     */
    public static function createHashForPlan(Plan $plan)
    {
        return self::hashString(
            $plan->getUser()->getUsername() . $plan->getHolidayBegin()->getTimestamp() . $plan->getNotice()
        );
    }

    /**
     * Create Hash from String and TYPO3 Encryption Key (if available).
     *
     * @param string $string Any String to hash
     * @param int $length Hash Length
     * @throws \Exception
     * @return string $hash Hashed String
     */
    protected static function hashString($string, $length = 20)
    {
        return GeneralUtility::shortMD5($string . self::getEncryptionKey(), $length);
    }

    /**
     * Get TYPO3 encryption key.
     *
     * @throws \Exception
     * @return string
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getEncryptionKey()
    {
        if (empty($GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'])) {
            throw new Exception('No encryption key found in this TYPO3 installation');
        }

        return $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
    }
}
