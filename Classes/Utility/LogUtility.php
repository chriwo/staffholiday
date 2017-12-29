<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Model\Log;
use ChriWo\Staffholiday\Domain\Model\Plan;
use ChriWo\Staffholiday\Domain\Repository\LogRepository;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

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
        self::getDispatcher()->dispatch(__CLASS__, __FUNCTION__ . 'Custom', [$state, $plan, $additionalProperties]);
    }

    /**
     * @return Dispatcher
     */
    protected static function getDispatcher()
    {
        return self::getObjectManager()->get(Dispatcher::class);
    }

    /**
     * @return Log
     */
    protected static function getLog()
    {
        return self::getObjectManager()->get(Log::class);
    }

    /**
     * @return LogRepository
     */
    protected static function getLogRepository()
    {
        return self::getObjectManager()->get(LogRepository::class);
    }
}
