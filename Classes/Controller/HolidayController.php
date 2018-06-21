<?php
namespace ChriWo\Staffholiday\Controller;

use ChriWo\Staffholiday\Utility\FileUtility;
use ChriWo\Staffholiday\Utility\LocalizationUtility;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class HolidayController.
 */
class HolidayController extends AbstractController
{
    /**
     * @param array $filter
     * @return void
     */
    public function listAction($filter = [])
    {
        if ($this->settings['list']['user'] === '[this]') {
            $this->settings['list']['user'] = (int) $this->user->getUid();
        }

        $this->settings['list']['filter'] = array_merge_recursive($this->settings['list']['filter'], $filter);

        $holidayPlans = $this->planRepository->findDemanded($this->settings);
        $this->view->assignMultiple(
            [
                'holidayPlans' => $holidayPlans,
                'filter' => $filter,
                'format' => LocalizationUtility::translateByConfiguration(),
                'uploadFolder' => FileUtility::getUploadFolderFromTca(),
            ]
        );
    }
}
