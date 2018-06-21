<?php
namespace ChriWo\Staffholiday\ViewHelpers\Form;

use ChriWo\Staffholiday\Utility\LocalizationUtility;
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
     */
    protected $planRepository;

    /**
     * Inject a plan repository
     *
     * @param \ChriWo\Staffholiday\Domain\Repository\PlanRepository $planRepository
     */
    public function injectPlanRepository(\ChriWo\Staffholiday\Domain\Repository\PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

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
