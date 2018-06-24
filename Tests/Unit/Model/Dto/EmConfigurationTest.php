<?php
namespace ChriWo\Staffholiday\Tests\Unit\Model\Dto;

use ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration;
use PHPUnit\Framework\TestCase;

class EmConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function defaultSettingsCouldBeSet()
    {
        $default = [
            'disableLog' => false,
            'hideHolidayPlanTable' => false,
            'dateTimeHoliday' => 'datetime'
        ];

        $model = new EmConfiguration($default);

        $this->assertFalse($model->isDisableLog());
        $this->assertFalse($model->isHideHolidayPlanTable());
        $this->assertEquals('datetime', $model->getDateTimeHoliday());
    }

    /**
     * Test if the disable log flag could be set
     * @test
     */
    public function disableLogFlagCanBeSetToTrue()
    {
        $model = new EmConfiguration(['disableLog' => false]);
        $model->setDisableLog(true);
        $this->assertTrue($model->isDisableLog());
    }

    /**
     * Test if the hide holiday plan table flag could be set
     * @test
     */
    public function hideHolidayPlanTableFlagCanBeSetToTrue()
    {
        $model = new EmConfiguration(['hideHolidayPlanTable' => false]);
        $model->setHideHolidayPlanTable(true);
        $this->assertTrue($model->isHideHolidayPlanTable());
    }

    /**
     * Test if correct date time string is returned
     * @test
     */
    public function returnDateTimeString()
    {
        $model = new EmConfiguration(['dateTimeHoliday' => 'date']);
        $model->setDateTimeHoliday('datetime');
        $this->assertEquals('datetime', $model->getDateTimeHoliday());
    }

    /**
     * Test if correct date string is returned
     * @test
     */
    public function returnHtml5DateTimeString()
    {
        $model = new EmConfiguration(['dateTimeHoliday' => 'date']);
        $this->assertEquals('date', $model->getDateTimeHolidayHtml5());
    }

    /**
     * Test if correct date time local string is returned
     * @test
     */
    public function returnHtml5DateTimeLocalString()
    {
        $model = new EmConfiguration(['dateTimeHoliday' => 'date']);
        $model->setDateTimeHoliday('datetime');
        $this->assertEquals('datetime-local', $model->getDateTimeHolidayHtml5());
    }
}
