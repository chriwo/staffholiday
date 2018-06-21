<?php
namespace ChriWo\Staffholiday\Utility;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
