<?php
namespace ChriWo\Staffholiday\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
