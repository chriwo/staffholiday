<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Model\Log;
use ChriWo\Staffholiday\Domain\Repository\LogRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

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
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
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
     * @return \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     */
    protected static function getConfigurationManager()
    {
        return self::getObjectManager()->get(ConfigurationManager::class);
    }

    /**
     * Create an instance of connection pool.
     *
     * @return \TYPO3\CMS\Core\Database\ConnectionPool
     */
    protected static function getConnectionPool()
    {
        return self::getObjectManager()->get(ConnectionPool::class);
    }

    /**
     * Returns an dispatcher
     * @return Dispatcher
     */
    protected static function getDispatcher()
    {
        return self::getObjectManager()->get(Dispatcher::class);
    }

    /**
     * Returns an log object
     * @return Log
     */
    protected static function getLog()
    {
        return self::getObjectManager()->get(Log::class);
    }

    /**
     * Returns an log repository
     * @return LogRepository
     */
    protected static function getLogRepository()
    {
        return self::getObjectManager()->get(LogRepository::class);
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
