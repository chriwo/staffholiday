<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Model\Plan;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Exception;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Christian Wolfram <c.wolfram@chriwo.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
