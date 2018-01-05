<?php
namespace ChriWo\Staffholiday\Controller;

use ChriWo\Staffholiday\Domain\Model\Log;
use ChriWo\Staffholiday\Domain\Model\Plan;
use ChriWo\Staffholiday\Utility\AbstractUtility;
use ChriWo\Staffholiday\Utility\EmConfigurationUtility;
use ChriWo\Staffholiday\Utility\FrontendUtility;
use ChriWo\Staffholiday\Utility\HashEncryptionUtility;
use ChriWo\Staffholiday\Utility\LocalizationUtility;
use ChriWo\Staffholiday\Utility\LogUtility;
use ChriWo\Staffholiday\Utility\StringUtility;
use ChriWo\Staffholiday\Utility\UserUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
 * Class AbstractController.
 */
abstract class AbstractController extends ActionController
{
    /**
     * Current logged in user object.
     *
     * @var \ChriWo\Staffholiday\Domain\Model\User
     */
    public $user;
    /**
     * @var \ChriWo\Staffholiday\Domain\Repository\PlanRepository
     * @inject
     */
    protected $planRepository;

    /**
     * @var \ChriWo\Staffholiday\Domain\Service\SendMailService
     * @inject
     */
    protected $sendMailService;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    protected $contentObject;

    /**
     * @var \ChriWo\Staffholiday\Domain\Model\Dto\EmConfiguration
     */
    protected $emConfiguration;

    public function initializeAction()
    {
        $this->user = UserUtility::getCurrentUser();

        $this->config = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        );
        $this->config = $this->config['plugin.']['tx_staffholiday.']['settings.'];
        $this->contentObject = $this->configurationManager->getContentObject();

        $this->emConfiguration = EmConfigurationUtility::getSettings();
    }

    /**
     * Assigns all values, which should be available in all views.
     *
     * @return void
     */
    public function assignForAll()
    {
        $storagePid = null !== $this->user ? $this->user->getPid() : 0;

        $this->view->assignMultiple(
            [
                'languageUid' => FrontendUtility::getFrontendLanguageUid(),
                'Pid' => $storagePid,
                'dateTimeSetting' => $this->emConfiguration->getDateTimeHolidayHtml5(),
            ]
        );
    }

    /**
     * Prefix method to createAction(). Create Confirmation from Admin is not necessary.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function createAllConfirmed(Plan $plan)
    {
        $plan->setStatus(Plan::STATUS_CONFIRMED);
        $this->planRepository->add($plan);
        AbstractUtility::getPersistenceManager()->persistAll();

        $this->addFlashMessage(LocalizationUtility::translate('create'));
        LogUtility::log(Log::STATUS_NEWPLAN, $plan);
        $this->finalCreate($plan, 'new', 'createStatus');
    }

    /**
     * Prefix method to createAction(): Create must be confirmed by Admin or User.
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
    public function createRequest(Plan $plan)
    {
        $this->planRepository->add($plan);

        AbstractUtility::getPersistenceManager()->persistAll();
        LogUtility::log(Log::STATUS_PLANREQUEST, $plan);

        $this->createAdminConfirmationRequest($plan);
    }

    /**
     * Some additional actions after profile creation.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @param string $action
     * @param string $redirectByActionName Action to redirect
     * @param string $status
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @return void
     */
    public function finalCreate($plan, $action, $redirectByActionName, $status = '')
    {
        $variables = [
            'plan' => $plan,
            'settings' => $this->settings,
            'dateTimeSetting' => 'format-' . $this->emConfiguration->getDateTimeHoliday(),
        ];

        $this->sendMailService->send(
            'createUserNotify',
            StringUtility::makeEmailArray(
                $plan->getUser()->getEmail(),
                $plan->getUser()->getFirstName() . ' ' . $plan->getUser()->getLastName()
            ),
            StringUtility::makeEmailArray(
                $this->settings['new']['email']['createUserNotify']['sender']['email']['value'],
                $this->settings['settings']['new']['email']['createUserNotify']['sender']['name']['value']
            ),
            'Plan creation',
            $variables,
            $this->config['new.']['email.']['createUserNotify.']
        );

        $this->signalSlotDispatcher->dispatch(__CLASS__, __FUNCTION__ . 'AfterPersist', [$plan, $action, $this]);
        $this->redirectByAction($action, ($status ? $status . 'Redirect' : 'redirect'));
        $this->redirect($redirectByActionName);
    }

    /**
     * Send email to admin for confirmation.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @throws \Exception
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @return void
     */
    protected function createAdminConfirmationRequest(Plan $plan)
    {
        $variables = [
            'plan' => $plan,
            'hash' => HashEncryptionUtility::createHashForPlan($plan),
            'settings' => $this->settings,
            'dateTimeSetting' => 'format-' . $this->emConfiguration->getDateTimeHoliday(),
        ];

        $this->addFlashMessage(LocalizationUtility::translate('createRequestWaitingForAdminConfirm'));
        $this->sendMailService->send(
            'createAdminConfirmation',
            StringUtility::makeEmailArray(
                $this->settings['new']['email']['createAdminConfirmation']['receiver']['email']['value'],
                $this->settings['new']['email']['createAdminConfirmation']['receiver']['name']['value']
            ),
            StringUtility::makeEmailArray(
                $this->settings['new']['email']['createUserNotify']['sender']['email']['value'],
                $this->settings['settings']['new']['email']['createUserNotify']['sender']['name']['value']
            ),
            'New Registration request',
            $variables,
            $this->config['new.']['email.']['createAdminConfirmation.']
        );
        $this->redirect('new');
    }

    /**
     * Redirect by TypoScript setting
     *        [userConfirmation|userConfirmationRefused|adminConfirmation|
     *        adminConfirmationRefused|adminConfirmationRefusedSilent]Redirect.
     *
     * @param string $action "new", "edit"
     * @param string $category "redirect", "requestRedirect" value from TypoScript
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @return void
     */
    protected function redirectByAction($action = 'new', $category = 'redirect')
    {
        $target = null;
        // redirect from TypoScript cObject
        if ($this->contentObject->cObjGetSingle(
            $this->config[$action . '.'][$category],
            $this->config[$action . '.'][$category . '.']
        )
        ) {
            $target = $this->contentObject->cObjGetSingle(
                $this->config[$action . '.'][$category],
                $this->config[$action . '.'][$category . '.']
            );
        }

        // if redirect target
        if ($target) {
            $this->uriBuilder->setTargetPageUid($target);
            $this->uriBuilder->setLinkAccessRestrictedPages(true);
            $link = $this->uriBuilder->build();
            $this->redirectToUri(StringUtility::removeDoubleSlashesFromUri($link));
        }
    }

    /**
     * Check if user is authenticated.
     *
     * @param \ChriWo\Staffholiday\Domain\Model\User $user
     * @param int $uid Given fe_users uid
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @return void
     */
    protected function testSpoof($user, $uid)
    {
        if ($user->getUid() !== (int) $uid && $uid > 0) {
            $this->addFlashMessage(
                LocalizationUtility::translateByState(Log::STATUS_PLANREFUSEDUSER),
                '',
                FlashMessage::ERROR
            );
            $this->forward('new');
        }
    }

    /**
     * @param array $plan
     * @return void
     */
    protected function prepareDateTime(array &$plan)
    {
        if ('datetime' === $this->emConfiguration->getDateTimeHoliday()) {
            $plan['holidayBegin'] = str_replace('T', ' ', $plan['holidayBegin']) . ':00';
            $plan['holidayEnd'] = str_replace('T', ' ', $plan['holidayEnd']) . ':00';
        } else {
            $plan['holidayBegin'] .= ' 00:00:00';
            $plan['holidayEnd'] .= ' 00:00:00';
        }
    }

    /**
     * Deactivate error messages in flash messages.
     *
     * @return bool
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
