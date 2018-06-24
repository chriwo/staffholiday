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

/**
 * Class ObjectUtility
 */
class ObjectUtility extends AbstractUtility
{
    /**
     * Returns an connection pool
     * @return \TYPO3\CMS\Core\Database\ConnectionPool
     */
    public static function getConnectionPool()
    {
        return parent::getConnectionPool();
    }

    /**
     * Returns an log object
     * @return \ChriWo\Staffholiday\Domain\Model\Log
     */
    public static function getLog()
    {
        return parent::getLog();
    }

    /**
     * Returns an log repository
     * @return \ChriWo\Staffholiday\Domain\Repository\LogRepository
     */
    public static function getLogRepository()
    {
        return parent::getLogRepository();
    }

    /**
     * Returns an dispatcher
     * @return \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    public static function getDispatcher()
    {
        return parent::getDispatcher();
    }
}
