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
 * Class FileUtility.
 */
class FileUtility extends AbstractUtility
{
    /**
     * Read fe_users image upload folder from TCA.
     *
     * @return string path - standard "uploads/pics"
     */
    public static function getUploadFolderFromTca()
    {
        $tca = self::getTcaFromTable();
        $path = $tca['columns']['image']['config']['uploadfolder'];
        if (empty($path)) {
            $path = 'uploads/pics';
        }

        return $path;
    }
}
