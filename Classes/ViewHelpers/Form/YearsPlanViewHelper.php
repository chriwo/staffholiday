<?php
declare(strict_types=1);
namespace ChriWo\Staffholiday\ViewHelpers\Form;

use ChriWo\Staffholiday\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

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

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('excludeExpired', 'bool', 'Exclude expired holidays', false, 'bool');
    }

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
     * @return array
     */
    public function render(): array
    {
        $resultYears = [
            '' => LocalizationUtility::translate('filterYearPlaceholder'),
        ];
        $years = $this->planRepository->findYears($this->arguments['excludeExpired']);

        foreach ($years as $year) {
            $resultYears[$year['years']] = $year['years'];
        }

        return $resultYears;
    }
}
