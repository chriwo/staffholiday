<?php
namespace ChriWo\Staffholiday\Tests\Unit\ViewHelpers;

use ChriWo\Staffholiday\ViewHelpers\FirstImageViewHelper;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class FirstImageViewHelperTest extends UnitTestCase
{
    /**
     * @var \ChriWo\Staffholiday\ViewHelpers\FirstImageViewHelper
     */
    protected $viewHelper;

    public function setUp()
    {
        parent::setUp();
        $this->viewHelper = new FirstImageViewHelper();
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->viewHelper);
    }

    /**
     * @test
     */
    public function trimListAndReturnFirstItem()
    {
        $this->assertNotEmpty($this->viewHelper->render('abc.jpg,zxz.pdf'));
        $this->assertEquals('abc.jpg', $this->viewHelper->render('abc.jpg,zxz.pdf'));
    }


    /**
     * @test
     * @dataProvider separatorDataProvider
     * @param string $string
     * @param string $separator
     * @param bool $trim
     * @param string $expected
     */
    public function respectSeparatorAndReturnFirstItem($string, $separator, $trim, $expected)
    {
        $this->assertEquals($expected, $this->viewHelper->render($string, $separator, $trim));
    }

    /**
     *
     * @return array
     */
    public function separatorDataProvider()
    {
        return [
            'Default comma separator' => [
                'abc.jpg,anotherString,download-file.pdf',
                ',',
                true,
                'abc.jpg'
            ],
            'Use dot as separator' => [
                'abc.jpg,anotherString,download-file.pdf',
                '.',
                true,
                'abc'
            ],
            'No trim result' => [
                'abc.jpg ,file-download.pdf',
                ',',
                false,
                'abc.jpg '
            ],
            'Empty string given returns empty string' => [
                '',
                ',',
                true,
                ''
            ]
        ];
    }
}
