<?php
namespace ChriWo\Staffholiday\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
