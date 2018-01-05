<?php
namespace ChriWo\Staffholiday\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 - 2018 Christian Wolfram <c.wolfram@chriwo.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
