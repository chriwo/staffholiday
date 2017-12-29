<?php
namespace ChriWo\Staffholiday\Controller;

use ChriWo\Staffholiday\Utility\FileUtility;
use ChriWo\Staffholiday\Utility\LocalizationUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Christian Wolfram <c.wolfram@chriwo.de>
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
