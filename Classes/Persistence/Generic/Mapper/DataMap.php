<?php
namespace ChriWo\Staffholiday\Persistence\Generic\Mapper;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class DataMap.
 *
 * Disable tx_extbase_type='0' in where clause for staffholiday
 */
class DataMap extends \TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMap
{
    /**
     * Sets the record type.
     *
     * @param string $recordType The record type
     * @return void
     */
    public function setRecordType($recordType)
    {
        parent::setRecordType($recordType);

        if ('ChriWo\\Staffholiday\\Domain\\Model\\User' === $this->getClassName()
            || 'ChriWo\\Staffholiday\\Domain\\Model\\UserGroup' === $this->getClassName()
        ) {
            $this->recordType = null;
        }
    }
}
