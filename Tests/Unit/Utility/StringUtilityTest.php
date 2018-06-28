<?php
namespace ChriWo\Staffholiday\Tests\Unit\Utility;

use ChriWo\Staffholiday\Utility\StringUtility;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

class StringUtilityTest extends UnitTestCase
{
    /**
     *
     * @test
     * @dataProvider emailStringWithDefinedEmailNameDataProvider
     * @param string $emailString
     * @param string $emailName
     * @param array $expected
     */
    public function emailStringReturnEmailArrayWithDefineEmailName($emailString, $emailName, $expected)
    {
        $this->assertEquals($expected, StringUtility::makeEmailArray($emailString, $emailName));
    }

    /**
     *
     * @return array
     */
    public function emailStringWithDefinedEmailNameDataProvider()
    {
        return [
            'Valid email with default name' => [
                'dummy@domain.com',
                'Holiday-Planing at company',
                [
                    'dummy@domain.com' => 'Holiday-Planing at company'
                ]
            ],
            'Multiple email adresses with one wrong address' => [
                'mail@mail.com' . PHP_EOL . 'dummydomain.com ' . PHP_EOL . 'customer@test.org',
                'My Holiday planning',
                [
                    'mail@mail.com' => 'My Holiday planning',
                    'customer@test.org' => 'My Holiday planning'
                ]
            ],
            'Email string with whitespace in prefix and/or suffix' => [
                ' prefix-whitespace@domain.com'
                . PHP_EOL . 'suffix-whitespace@domain.com '
                . PHP_EOL . ' prefix-and-suffix-whitespace@domain.com ',
                'staffholiday',
                [
                    'prefix-whitespace@domain.com' => 'staffholiday',
                    'suffix-whitespace@domain.com' => 'staffholiday',
                    'prefix-and-suffix-whitespace@domain.com' => 'staffholiday'
                ]
            ],
            'Wrong email address returns empty array' => [
                'wrong-mail-adress@domain',
                'Holiday-Planing at company',
                []
            ],
            'Empty email string' => [
                '',
                'Staffholiday',
                []
            ]
        ];
    }

    /**
     *
     * @test
     * @dataProvider emailStringWithUndefinedEmailNameDataProvider
     * @param string $emailString
     * @param array $expected
     */
    public function emailStringReturnEmailArrayWithUndefineEmailName($emailString, $expected)
    {
        $this->assertEquals($expected, StringUtility::makeEmailArray($emailString));
    }

    /**
     *
     * @return array
     */
    public function emailStringWithUndefinedEmailNameDataProvider()
    {
        return [
            'Valid email with default name' => [
                'dummy@domain.com',
                [
                    'dummy@domain.com' => 'staffholiday'
                ]
            ],
            'Multiple email addresses with one wrong address' => [
                'mail@mail.com' . PHP_EOL . 'dummydomain.com' . PHP_EOL . 'customer@test.org',
                [
                    'mail@mail.com' => 'staffholiday',
                    'customer@test.org' => 'staffholiday'
                ]
            ],
            'Email string with whitespace in prefix and/or suffix' => [
                ' prefix-whitespace@domain.com'
                . PHP_EOL . 'suffix-whitespace@domain.com '
                . PHP_EOL . ' prefix-and-suffix-whitespace@domain.com ',
                [
                    'prefix-whitespace@domain.com' => 'staffholiday',
                    'suffix-whitespace@domain.com' => 'staffholiday',
                    'prefix-and-suffix-whitespace@domain.com' => 'staffholiday'
                ]
            ],
            'Wrong email address returns empty array' => [
                'wrong-mail-adress@domain',
                []
            ],
            'Empty email string' => [
                '',
                []
            ]
        ];
    }

    /**
     *
     * @test
     * @dataProvider uriDataProvider
     * @param string $uri
     * @param string $expected
     */
    public function doubleSlashesCouldBeRemovedFromUri($uri, $expected)
    {
        $this->assertEquals($expected, StringUtility::removeDoubleSlashesFromUri($uri));
    }

    /**
     *
     * @return array
     */
    public function uriDataProvider()
    {
        return [
            'Uri (http) with double slashes' => [
                'http://www.my-uri.com/folder//index.html',
                'http://www.my-uri.com/folder/index.html'
            ],
            'Uri (https) with double slashes' => [
                'https://www.my-uri.com/folder//index.html',
                'https://www.my-uri.com/folder/index.html'
            ],
            'Uri without double slashes' => [
                'http://www.my-uri.com/folder/index.html',
                'http://www.my-uri.com/folder/index.html'
            ],
            'Uri without protocol but with double slashes' => [
                'www.my-uri.com//folder//index.html',
                'www.my-uri.com/folder/index.html'
            ],
            'Non uri string' => [
                'this is not an uri but has // slashes',
                'this is not an uri but has / slashes'
            ]
        ];
    }
}
