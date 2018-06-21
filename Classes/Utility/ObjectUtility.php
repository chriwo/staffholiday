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
     *
     * @return object|\TYPO3\CMS\Core\Database\ConnectionPool
     */
    public static function getConnectionPool()
    {
        return parent::getConnectionPool();
    }
}
