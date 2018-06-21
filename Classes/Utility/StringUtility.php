<?php
namespace ChriWo\Staffholiday\Utility;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class StringUtility.
 */
class StringUtility extends AbstractUtility
{
    /**
     * Create array for swiftmailer sender and receiver mail/name combination with fallback.
     *
     * @param string $emailString String with separated emails (splitted by \n)
     * @param string $name Name for every email name combination
     * @return array $mailArray
     */
    public static function makeEmailArray($emailString, $name = 'staffholiday')
    {
        $emails = GeneralUtility::trimExplode(PHP_EOL, $emailString, true);
        $mailArray = [];
        foreach ($emails as $email) {
            if (GeneralUtility::validEmail($email)) {
                $mailArray[$email] = $name;
            }
        }

        return $mailArray;
    }

    /**
     * Remove double slashes from URI but don't touch the protocol (http:// e.g.).
     *
     * @param string $string
     * @return string
     */
    public static function removeDoubleSlashesFromUri($string)
    {
        return preg_replace('~([^:]|^)(/{2,})~', '$1/', $string);
    }
}
