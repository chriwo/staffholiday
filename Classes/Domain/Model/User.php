<?php
namespace ChriWo\Staffholiday\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * User Model.
 */
class User extends FrontendUser
{
    /**
     * txExtbaseType.
     *
     * @var string
     */
    protected $txExtbaseType;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\ChriWo\Staffholiday\Domain\Model\Plan>
     * @lazy
     */
    protected $txStaffholidayPlan;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct($username = '', $password = '')
    {
        parent::__construct($username, $password);
        $this->txStaffholidayPlan = new ObjectStorage();
    }

    /**
     * @param string $txExtbaseType
     * @return \ChriWo\Staffholiday\Domain\Model\User
     */
    public function setTxExtbaseType($txExtbaseType)
    {
        $this->txExtbaseType = $txExtbaseType;

        return $this;
    }

    /**
     * @return string
     */
    public function getTxExtbaseType()
    {
        return $this->txExtbaseType;
    }

    /**
     * Return all holiday plans as object storage.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getTxStaffholidayPlan()
    {
        return $this->txStaffholidayPlan;
    }

    /**
     * Set an storage with holiday plans.
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $txStaffholidayPlan
     * @return \ChriWo\Staffholiday\Domain\Model\User
     */
    public function setTxStaffholidayPlan($txStaffholidayPlan)
    {
        $this->txStaffholidayPlan = $txStaffholidayPlan;

        return $this;
    }

    /**
     * Add an holiday plan.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return void
     */
    public function addTxStaffholidayPlan(Plan $plan)
    {
        if (is_null($this->getTxStaffholidayPlan())) {
            $this->txStaffholidayPlan = new ObjectStorage();
        }

        $this->txStaffholidayPlan->attach($plan);
    }

    /**
     * Remove an holiday plan.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return void
     */
    public function removeTxStaffholidayPlan(Plan $plan)
    {
        if (!is_null($this->getTxStaffholidayPlan())) {
            $this->txStaffholidayPlan->detach($plan);
        }
    }
}
