<?php
namespace ChriWo\Staffholiday\Utility;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Utility class to get the settings from Extension Manager.
 */
class EmConfigurationUtility
{
    /**
     * Parses the extension settings.
     *
     * @return \ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration
     */
    public static function getSettings()
    {
        $settings = new \ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration(self::parseSettings());

        return $settings;
    }

    /**
     * Parse settings and return it as array.
     *
     * @return array unserialized extconf settings
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function parseSettings(): array
    {
        $settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['staffholiday']);

        if (!is_array($settings)) {
            $settings = [];
        }

        return $settings;
    }
}
