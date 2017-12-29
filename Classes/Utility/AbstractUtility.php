<?php
namespace ChriWo\Staffholiday\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * Class AbstractUtility.
 */
abstract class AbstractUtility
{
    /**
     * @return object|\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    public static function getPersistenceManager()
    {
        return self::getObjectManager()->get(PersistenceManager::class);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected static function getObjectManager()
    {
        return GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * @return object|\TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     */
    protected static function getConfigurationManager()
    {
        return self::getObjectManager()->get(ConfigurationManager::class);
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * Get table configuration array for a defined table.
     *
     * @param string $table
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getTcaFromTable($table = 'fe_users')
    {
        if (!empty($GLOBALS['TCA'][$table])) {
            return $GLOBALS['TCA'][$table];
        }

        return [];
    }
}
