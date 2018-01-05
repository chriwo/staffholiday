<?php
namespace ChriWo\Staffholiday\Persistence\Generic\Mapper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 - 2018 Christian Wolfram <c.wolfram@chriwo.de>
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
