<?php
namespace ChriWo\Staffholiday\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * View helper to explode a list.
 *
 * == Examples ==
 *
 * <code title="Default">
 *  <n:firstImage string="image1.jpg,image2.png"/>
 * </code>
 * <output>
 *  image1.jpg
 * </output>
 *
 * <code title="Default with separator definition">
 *  <n:firstImage string="image1.jpg;image2.png" separator=";"/>
 * </code>
 * <output>
 *  image1.jpg
 * </output>
 */
class FirstImageViewHelper extends AbstractViewHelper
{
    /**
     * View helper to explode a list.
     *
     * @param string $string Any list (e.g. "a,b,c,d")
     * @param string $separator Separator sign (e.g. ",")
     * @param bool $trim Should be trimmed?
     * @return string
     */
    public function render($string = '', $separator = ',', $trim = true)
    {
        $images = $trim ? GeneralUtility::trimExplode($separator, $string, true) : explode($separator, $string);
        if (count($images)) {
            return $images[0];
        }

        return '';
    }
}
