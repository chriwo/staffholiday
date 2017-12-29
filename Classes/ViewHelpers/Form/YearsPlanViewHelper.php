<?php
namespace ChriWo\Staffholiday\ViewHelpers\Form;

use ChriWo\Staffholiday\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

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
 * ViewHelper to return an array of years on holiday entries.
 *
 * == Examples ==
 *
 * <code title="Default">
 *  <n:form.yearsPlan excludeExpired="false"/>
 * </code>
 * <output>
 *  [
 *      2012 => 2012
 *      2013 => 2013
 *  ]
 * </output>
 */
class YearsPlanViewHelper extends AbstractViewHelper
{
    /**
     * @var \ChriWo\Staffholiday\Domain\Repository\PlanRepository
     * @inject
     */
    protected $planRepository;

    /**
     * @param bool $excludeExpired
     * @return array
     */
    public function render($excludeExpired = false)
    {
        $resultYears = [
            '' => LocalizationUtility::translate('filterYearPlaceholder'),
        ];
        $years = $this->planRepository->findYears($excludeExpired);

        foreach ($years as $year) {
            $resultYears[$year['years']] = $year['years'];
        }

        return $resultYears;
    }
}
