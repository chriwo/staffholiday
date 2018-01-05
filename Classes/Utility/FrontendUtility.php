<?php
namespace ChriWo\Staffholiday\Utility;

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
 * Class FrontendUtility
 */
class FrontendUtility extends AbstractUtility
{
    /**
     * Get frontend language uid
     *
     * @return int
     */
    public static function getFrontendLanguageUid()
    {
        if (!empty(self::getTypoScriptFrontendController()->tmpl->setup['config.']['sys_language_uid'])) {
            return (int) self::getTypoScriptFrontendController()->tmpl->setup['config.']['sys_language_uid'];
        }
        return 0;
    }
}
