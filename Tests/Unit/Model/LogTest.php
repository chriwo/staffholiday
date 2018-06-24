<?php
namespace ChriWo\Staffholiday\Tests\Unit\Model;

use ChriWo\Staffholiday\Domain\Model\Log;
use ChriWo\Staffholiday\Domain\Model\Plan;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class LogTest extends UnitTestCase
{
    /**
     * @var \ChriWo\Staffholiday\Domain\Model\Log
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new Log();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->model);
    }

    /**
     * Test if a title could be set
     * @test
     */
    public function titleOfLogCanBeSet()
    {
        $title = 'This a log title';
        $this->model->setTitle($title);
        $this->assertEquals($title, $this->model->getTitle());
    }

    /**
     * Test if a state could be set
     * @test
     */
    public function stateCanBeSet()
    {
        $this->model->setState(Log::STATUS_PLANREFUSEDADMIN);
        $this->assertEquals(Log::STATUS_PLANREFUSEDADMIN, $this->model->getState());
    }

    /**
     * Test if plan object could be set
     * @test
     */
    public function planObjectCanBeSet()
    {
        $plan = new Plan();
        $plan->setPid(45);
        $this->model->setPlan($plan);
        $this->assertEquals($plan, $this->model->getPlan());
    }
}
