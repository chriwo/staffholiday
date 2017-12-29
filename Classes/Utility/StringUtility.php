<?php
namespace ChriWo\Staffholiday\Utility;

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
