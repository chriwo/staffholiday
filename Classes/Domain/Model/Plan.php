<?php
namespace ChriWo\Staffholiday\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * Class Plan.
 */
class Plan extends AbstractEntity
{
    const STATUS_OPEN = 101;
    const STATUS_CONFIRMED = 102;
    const STATUS_REFUSED = 103;

    /**
     * @var \DateTime
     */
    protected $holidayBegin;

    /**
     * @var \DateTime
     */
    protected $holidayEnd;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $user;

    /**
     * @var string
     */
    protected $notice;

    /**
     * @var bool
     */
    protected $hidden;

    /**
     * Returns the begin of holiday.
     *
     * @return \DateTime
     */
    public function getHolidayBegin()
    {
        return $this->holidayBegin;
    }

    /**
     * Sets the begin of holiday.
     *
     * @param \DateTime $holidayBegin
     * @return void
     */
    public function setHolidayBegin($holidayBegin)
    {
        $this->holidayBegin = $holidayBegin;
    }

    /**
     * Returns the end of holiday.
     *
     * @return \DateTime
     */
    public function getHolidayEnd()
    {
        return $this->holidayEnd;
    }

    /**
     * Sets the end of holiday.
     *
     * @param \DateTime $holidayEnd
     * @return void
     */
    public function setHolidayEnd($holidayEnd)
    {
        $this->holidayEnd = $holidayEnd;
    }

    /**
     * Returns the status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status.
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the fe user.
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the fe user.
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Returns the notice.
     *
     * @return string
     */
    public function getNotice()
    {
        return $this->notice;
    }

    /**
     * Sets the notice.
     *
     * @param string $notice
     * @return void
     */
    public function setNotice($notice)
    {
        $this->notice = $notice;
    }

    /**
     * Returns the hidden flag.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets an flag for show or hidden.
     *
     * @param bool $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
