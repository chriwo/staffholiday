<?php
namespace ChriWo\Staffholiday\Domain\Model\Dto;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Extension Manager configuration.
 */
class EmConfiguration
{
    /**
     * @var bool
     */
    protected $disableLog;

    /**
     * @var bool
     */
    protected $hideHolidayPlanTable;

    /**
     * @var string
     */
    protected $dateTimeHoliday;

    /**
     * Fill the properties properly.
     *
     * @param array $configuration em configuration
     */
    public function __construct(array $configuration)
    {
        foreach ($configuration as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Returns disable log.
     *
     * @return bool
     */
    public function isDisableLog()
    {
        return $this->disableLog;
    }

    /**
     * Sets disable log.
     *
     * @param bool $disableLog
     * @return void
     */
    public function setDisableLog($disableLog)
    {
        $this->disableLog = $disableLog;
    }

    /**
     * Returns the display option in BE.
     *
     * @return bool
     */
    public function isHideHolidayPlanTable()
    {
        return $this->hideHolidayPlanTable;
    }

    /**
     * Sets the display option of holiday plan in BE.
     *
     * @param bool $hideHolidayPlanTable
     * @return void
     */
    public function setHideHolidayPlanTable($hideHolidayPlanTable)
    {
        $this->hideHolidayPlanTable = $hideHolidayPlanTable;
    }

    /**
     * Returns the used option datetime or date.
     *
     * @return string
     */
    public function getDateTimeHoliday()
    {
        return $this->dateTimeHoliday;
    }

    /**
     * Sets the option datetime or date.
     *
     * @param string $dateTimeHoliday
     * @return void
     */
    public function setDateTimeHoliday($dateTimeHoliday)
    {
        $this->dateTimeHoliday = $dateTimeHoliday;
    }

    /**
     * Return the date time option for html5 input field.
     *
     * @return string
     */
    public function getDateTimeHolidayHtml5()
    {
        $dateTime = $this->getDateTimeHoliday();
        if ('datetime' === $dateTime) {
            $dateTime .= '-local';
        }

        return $dateTime;
    }
}
