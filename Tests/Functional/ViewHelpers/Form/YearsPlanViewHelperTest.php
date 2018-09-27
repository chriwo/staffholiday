<?php
namespace ChriWo\Staffholiday\Tests\Functional\ViewHelpers\Form;

use ChriWo\Staffholiday\Domain\Repository\PlanRepository;
use ChriWo\Staffholiday\ViewHelpers\Form\YearsPlanViewHelper;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class YearsPlanViewHelperTest extends FunctionalTestCase
{
    /**
     * @var YearsPlanViewHelper
     */
    protected $mockedViewHelper;

    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/staffholiday'];

    /**
     * @var array
     */
    protected $coreExtensionsToLoad = ['extbase', 'fluid'];

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var PlanRepository
     */
    protected $planRepository;

    /**
     *
     * @throws \Nimut\TestingFramework\Exception\Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->planRepository = $this->objectManager->get('ChriWo\\Staffholiday\\Domain\\Repository\\PlanRepository');

        $this->mockedViewHelper = $this->getAccessibleMock(
            YearsPlanViewHelper::class,
            ['dummy'],
            [],
            '',
            true,
            true,
            false
        );
        $this->mockedViewHelper->injectPlanRepository($this->planRepository);
        $this->importDataSet(__DIR__ . '/../../Fixtures/tx_staffholiday_domain_model_plan.xml');
    }

    public function tearDown()
    {
        unset($this->mockedViewHelper);
    }

    /**
     * Test, if dabase query to group holiday years are correct.
     * The test result has 2 from 4 records loaded from database and add an empty record.
     *
     * @test
     */
    public function returnsOptionsFromDatabase()
    {
        $databaseResult = $this->mockedViewHelper->render();

        $this->assertArrayHasKey('', $databaseResult);
        $this->assertArrayHasKey(2016, $databaseResult);
        $this->assertArrayHasKey(2018, $databaseResult);
        $this->assertEquals('All years', $databaseResult['']);
        $this->assertCount(3, $databaseResult);
    }
}
