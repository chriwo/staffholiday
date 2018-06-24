<?php
namespace ChriWo\Staffholiday\Tests\Unit\Model;

use ChriWo\Staffholiday\Domain\Model\Plan;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

class PlanTest extends UnitTestCase
{
    /**
     * @var Plan
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Plan();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->model);
    }

    /**
     * Test if a holiday begin date object could be set and read
     * @test
     */
    public function holidayBeginCanBeSet()
    {
        $date = new \DateTime('2018-06-24 00:00:00');
        $this->model->setHolidayBegin($date);
        $this->assertEquals($date, $this->model->getHolidayBegin());
    }

    /**
     * Test if a holiday end date object could be set and read
     * @test
     */
    public function holidayEndDateCanBeSet()
    {
        $date = new \DateTime('2019-04-23 13:45:03');
        $this->model->setHolidayEnd($date);
        $this->assertEquals($date, $this->model->getHolidayEnd());
    }

    /**
     * Test if a status could be set
     * @test
     */
    public function statusCanBeSet()
    {
        $this->model->setStatus(Plan::STATUS_OPEN);
        $this->assertEquals(Plan::STATUS_OPEN, $this->model->getStatus());
    }

    /**
     * Test if a user object could be set
     * @test
     */
    public function frontendUserCanBeSet()
    {
        $user = new FrontendUser();
        $user->setUsername('a-unique-username');

        $this->model->setUser($user);
        $this->assertEquals($user, $this->model->getUser());
    }

    /**
     * Test if a notice could be set and red
     * @test
     */
    public function noticeCanBeSet()
    {
        $notice = 'A notice could be a long string';
        $this->model->setNotice($notice);
        $this->assertEquals($notice, $this->model->getNotice());
    }

    /**
     * Test if a flag to show or hide a plan
     * @test
     */
    public function hiddenFlagForPlanCanBeSet()
    {
        $flag = false;
        $this->model->setHidden($flag);
        $this->assertFalse($this->model->isHidden());
    }
}
