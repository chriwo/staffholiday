<?php
namespace ChriWo\Staffholiday\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * Log Model.
 */
class Log extends AbstractEntity
{
    const STATUS_NEWPLAN = 101;
    const STATUS_PLANCONFIRMEDADMIN = 102;
    const STATUS_PLANREFUSEDUSER = 103;
    const STATUS_PLANREFUSEDADMIN = 104;
    const STATUS_PLANREQUEST = 105;
    const STATUS_PLANUPDATED = 201;
    const STATUS_PLANDELETED = 301;

    /**
     * title.
     *
     * @var string
     */
    protected $title;

    /**
     * state.
     *
     * @var int
     */
    protected $state;

    /**
     * plan.
     *
     * @var \ChriWo\Staffholiday\Domain\Model\Plan
     */
    protected $plan;

    /**
     * @param string $title
     * @return Log
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param int $state
     * @return Log
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set user.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return Log
     */
    public function setPlan(Plan $plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \ChriWo\Staffholiday\Domain\Model\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }
}
