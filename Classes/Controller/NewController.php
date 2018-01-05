<?php
namespace ChriWo\Staffholiday\Controller;

use ChriWo\Staffholiday\Domain\Model\Log;
use ChriWo\Staffholiday\Domain\Model\Plan;
use ChriWo\Staffholiday\Utility\HashEncryptionUtility;
use ChriWo\Staffholiday\Utility\LocalizationUtility;
use ChriWo\Staffholiday\Utility\LogUtility;
use ChriWo\Staffholiday\Utility\StringUtility;
use ChriWo\Staffholiday\Utility\UserUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter;

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
 * Class NewController.
 */
class NewController extends AbstractController
{
    /**
     * @param \ChriWo\Staffholiday\Domain\Model\Plan|null $plan
     * @return void
     */
    public function newAction(Plan $plan = null)
    {
        $this->view->assignMultiple(
            [
                'user' => $this->user,
                'plan' => $plan,
            ]
        );

        $this->assignForAll();
    }

    /**
     * action create.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return void
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function createAction(Plan $plan)
    {
        $plan->setPid($this->user->getPid());
        $plan->setStatus(Plan::STATUS_OPEN);

        $this->signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'BeforePersist', [$plan, $this]);

        if ($this->isAllConfirmed()) {
            $this->createRequest($plan);
        } else {
            $this->createAllConfirmed($plan);
        }
    }

    /**
     * Dispatcher action for every confirmation request.
     *
     * @param int $plan Plan UID (plan could be hidden)
     * @param string $hash Given hash
     * @param string $status
     *            "userConfirmation", "userConfirmationRefused", "adminConfirmation",
     *            "adminConfirmationRefused", "adminConfirmationRefusedSilent"
     * @return void
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function confirmCreateRequestAction($plan, $hash, $status = 'adminConfirmation')
    {
        $plan = $this->planRepository->findByUid($plan);
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            __FUNCTION__ . 'BeforePersist',
            [$plan, $hash, $status, $this]
        );
        if (null === $plan) {
            $this->addFlashMessage(LocalizationUtility::translate('missingPlanInDatabase'), '', FlashMessage::ERROR);
            $this->redirect('new');
        }

        switch ($status) {
            case 'adminConfirmation':
                $furtherFunctions = $this->statusAdminConfirmation($plan, $hash, $status);
                break;
            case 'adminConfirmationRefused':
                $furtherFunctions = $this->statusAdminConfirmationRefused($plan, $hash, $status);
                break;
            default:
                $furtherFunctions = false;
        }

        if ($furtherFunctions) {
            $this->redirectByAction('new', $status . 'Redirect');
        }

        $this->redirect('new');
    }

    /**
     * Just for showing information after user creation.
     *
     * @return void
     */
    public function createStatusAction()
    {
    }

    /**
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function initializeCreateAction()
    {
        $user = UserUtility::getCurrentUser();
        $planValues = $this->request->getArgument('plan');
        $this->testSpoof($user, $planValues['user']['__identity']);
        $this->prepareDateTime($planValues);

        $this->request->setArgument('plan', $planValues);

        $this->arguments['plan']
            ->getPropertyMappingConfiguration()
            ->forProperty('holidayBegin')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'Y-m-d H:i:s'
            );
        $this->arguments['plan']
            ->getPropertyMappingConfiguration()
            ->forProperty('holidayEnd')
            ->setTypeConverterOption(
                DateTimeConverter::class,
                DateTimeConverter::CONFIGURATION_DATE_FORMAT,
                'Y-m-d H:i:s'
            );
    }

    /**
     * Status action: Admin confirmation.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @param string $hash
     * @param string $status
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @return bool allow further functions
     */
    protected function statusAdminConfirmation(Plan $plan, $hash, $status)
    {
        if (HashEncryptionUtility::validPlanHash($hash, $plan)) {
            $plan->setStatus(Plan::STATUS_CONFIRMED);
            $this->planRepository->update($plan);
            $this->addFlashMessage(LocalizationUtility::translate('createPlanSuccess'));
            LogUtility::log(Log::STATUS_PLANCONFIRMEDADMIN, $plan);
            $this->finalCreate($plan, 'new', 'createStatus', $status);
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('createFailedPlan'), '', FlashMessage::ERROR);

            return false;
        }

        return true;
    }

    /**
     * Status action: Admin refused profile creation (normal or silent).
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @param string $hash
     * @param string $status
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @return bool allow further functions
     */
    protected function statusAdminConfirmationRefused(Plan $plan, $hash, $status)
    {
        if (HashEncryptionUtility::validPlanHash($hash, $plan)) {
            $plan->setStatus(Plan::STATUS_REFUSED);
            $this->planRepository->update($plan);
            $this->addFlashMessage(LocalizationUtility::translate('createPlanCanceled'));
            LogUtility::log(Log::STATUS_PLANREFUSEDADMIN, $plan);

            $variables = [
                'plan' => $plan,
                'settings' => $this->settings,
                'dateTimeSetting' => 'format-' . $this->emConfiguration->getDateTimeHoliday(),
            ];

            $this->sendMailService->send(
                'CreateUserNotifyRefused',
                StringUtility::makeEmailArray(
                    $plan->getUser()->getEmail(),
                    $plan->getUser()->getFirstName() . ' ' . $plan->getUser()->getLastName()
                ),
                StringUtility::makeEmailArray(
                    $this->settings['new']['email']['createUserNotifyRefused']['sender']['email']['value'],
                    $this->settings['settings']['new']['email']['createUserNotifyRefused']['sender']['name']['value']
                ),
                'Your vacation was refused',
                $variables,
                $this->config['new.']['email.']['createUserNotifyRefused.']
            );
            $this->redirectByAction('new', ($status ? $status . 'Redirect' : 'redirect'));
            $this->redirect('createStatus');
        } else {
            $this->addFlashMessage(LocalizationUtility::translate('createFailedPlan'), '', FlashMessage::ERROR);

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function isAllConfirmed()
    {
        return (bool) $this->settings['new']['confirmByAdmin'];
    }
}
