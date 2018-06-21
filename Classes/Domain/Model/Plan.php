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
