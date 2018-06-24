<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Model\Plan;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class LogUtility.
 */
class LogUtility extends AbstractUtility
{
    /**
     * @param int $state State to log
     * @param Plan $plan Related holiday plan
     * @param array $additionalProperties for individual logging
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @return void
     */
    public static function log($state, Plan $plan, array $additionalProperties = [])
    {
        $configuration = EmConfigurationUtility::getSettings();
        if (!$configuration->isDisableLog()) {
            $log = self::getLog();
            $log->setTitle(LocalizationUtility::translateByState($state));
            $log->setState($state);
            $log->setPlan($plan);
            $log->setPid($plan->getPid());
            self::getLogRepository()->add($log);
        }
        parent::getDispatcher()->dispatch(__CLASS__, __FUNCTION__ . 'Custom', [$state, $plan, $additionalProperties]);
    }
}
