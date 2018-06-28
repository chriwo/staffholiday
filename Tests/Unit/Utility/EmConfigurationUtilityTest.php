<?php
namespace ChriWo\Staffholiday\Tests\Unit\Utility;

use ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration;
use ChriWo\Staffholiday\Utility\EmConfigurationUtility;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class EmConfigurationUtilityTest extends UnitTestCase
{
    /**
     * Backup of $GLOBALS
     * @var array
     */
    private $backupGlobalVariables;

    /**
     * setUp function
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setUp()
    {
        $this->backupGlobalVariables = [
            'TYPO3_CONF_VARS' => $GLOBALS['TYPO3_CONF_VARS']
        ];
    }

    /**
     * tearDown function
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function tearDown()
    {
        foreach ($this->backupGlobalVariables as $key => $value) {
            $GLOBALS[$key] = $value;
        }
        unset($this->backupGlobalVariables);
    }

    /**
     * Test, if parsing the em-configuration settings returns the settings
     *
     * @test
     * @dataProvider settingsAreCorrectlyReturnedDataProvider
     * @param string|null$expectedFields
     * @param array $expected
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function settingsAreCorrectlyReturned($expectedFields, $expected)
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['staffholiday'] = $expectedFields;
        $this->assertEquals($expected, EmConfigurationUtility::parseSettings());
    }

    /**
     * Data provider of settingsAreCorrectlyReturned
     * @return array
     */
    public function settingsAreCorrectlyReturnedDataProvider()
    {
        return [
            'noConfigurationFound' => [
                null,
                []
            ],
            'wrongConfigurationFound' => [
                serialize('value 999'),
                []
            ],
            'correctConfigurationFound' => [
                serialize(['firstKey' => 'firstValue', 'secondKey' => 'secondValue']),
                [
                    'firstKey' => 'firstValue',
                    'secondKey' => 'secondValue'
                ]
            ]
        ];
    }

    /**
     * Test, if the configuration model is correctly returned
     * @test
     * @dataProvider extensionManagerConfigurationIsCorrectlyReturnedDataProvider
     * @param string|null $expectedFields
     * @param \ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration $expected
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function extensionManagerConfigurationIsCorrectlyReturned($expectedFields, $expected)
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['staffholiday'] = $expectedFields;
        $this->assertEquals($expected, EmConfigurationUtility::getSettings());
    }

    /**
     * Data provider of extensionManagerConfigurationIsCorrectlyReturned
     * @return array
     */
    public function extensionManagerConfigurationIsCorrectlyReturnedDataProvider()
    {
        return [
            'noConfigurationFound' => [
                null,
                new EmConfiguration([])
            ],
            'wrongConfigurationFound' => [
                serialize('value 999'),
                new EmConfiguration([])
            ],
            'noValidPropertiesFound' => [
                serialize(['firstKey' => 'firstValue', 'secondKey' => 'secondValue']),
                new EmConfiguration([])
            ],
            'validPropertiesFound' => [
                serialize(['firstKey' => 'firstValue', 'dateTimeHoliday' => 'datetime']),
                new EmConfiguration(['dateTimeHoliday' => 'datetime'])
            ]
        ];
    }
}
