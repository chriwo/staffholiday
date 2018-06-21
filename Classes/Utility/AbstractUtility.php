<?php
namespace ChriWo\Staffholiday\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
