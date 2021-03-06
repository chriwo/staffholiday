<?php
namespace ChriWo\Staffholiday\Domain\Service;

use ChriWo\Staffholiday\Utility\LocalizationUtility;
use ChriWo\Staffholiday\Utility\TemplateUtility;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * SendMail Function.
 */
class SendMailService
{
    /**
     * Content Object.
     *
     * @var object
     */
    public $cObj;
    /**
     * objectManager.
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * configurationManager.
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager
     */
    protected $configurationManager;

    /**
     * Inject a object manager
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Inject a configuration manager
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager
     */
    public function injectConfigurationMananger(
        \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager
    ) {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Generate and send Email.
     *
     * @param string $template Template file in Templates/Email/
     * @param array $receiver Combination of Email => Name
     * @param array $sender Combination of Email => Name
     * @param string $subject Mail subject
     * @param array $variables Variables for assignMultiple
     * @param array $typoScript Add TypoScript to overwrite values
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @return bool mail was sent?
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function send($template, $receiver, $sender, $subject, $variables = [], $typoScript = [])
    {
        // config
        $email = $this->objectManager->get(MailMessage::class);
        $this->cObj = $this->configurationManager->getContentObject();

        if (!empty($variables['plan']) && method_exists($variables['plan'], '_getProperties')) {
            $this->cObj->start($variables['plan']->_getProperties());
        }

        if (0 === count($receiver)) {
            return false;
        }

        /*
         * Generate and send Email
         */
        $email
            ->setTo($receiver)
            ->setFrom($sender)
            ->setSubject($subject)
            ->setCharset($GLOBALS['TSFE']->metaCharset)
            ->setBody($this->getMailBody($template, $variables), 'text/html');

        $this->overrideEmailReceiver($email, $typoScript);
        $this->overrideEmailSender($email, $typoScript);

        // overwrite email subject
        if ($this->cObj->cObjGetSingle($typoScript['subject'], $typoScript['subject.'])) {
            $email->setSubject($this->cObj->cObjGetSingle($typoScript['subject'], $typoScript['subject.']));
        }

        // add ics attachments
        if ($typoScript['attachIcsFile']) {
            $this->addIcsAttachment($email, $variables['plan']);
        }

        $email->send();

        return $email->isSent();
    }

    /**
     * Generate Email Body.
     *
     * @param string $template Template file in Templates/Email/
     * @param array $variables Variables for assignMultiple
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidControllerNameException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     * @return string
     */
    protected function getMailBody($template, $variables)
    {
        $standAloneView = TemplateUtility::getDefaultStandAloneView();
        $standAloneView->setTemplatePathAndFilename($this->getRelativeEmailPathAndFilename($template));
        $standAloneView->assignMultiple($variables);

        return $standAloneView->render();
    }

    /**
     * Override the email receiver
     *
     * @param MailMessage $email
     * @param array $typoScript
     * @return void
     */
    protected function overrideEmailReceiver(&$email, $typoScript)
    {
        if ($this->cObj->cObjGetSingle($typoScript['receiver.']['email'], $typoScript['receiver.']['email.'])
            && $this->cObj->cObjGetSingle($typoScript['receiver.']['name'], $typoScript['receiver.']['name.'])
        ) {
            $receiver = [
                $this->cObj->cObjGetSingle($typoScript['receiver.']['email'], $typoScript['receiver.']['email.']) =>
                    $this->cObj->cObjGetSingle($typoScript['receiver.']['name'], $typoScript['receiver.']['name.'])
            ];

            $email->setTo($receiver);
        }
    }

    /**
     * Override the email sender
     *
     * @param MailMessage $email
     * @param array $typoScript
     * @return void
     */
    protected function overrideEmailSender(&$email, $typoScript)
    {
        if ($this->cObj->cObjGetSingle($typoScript['sender.']['email'], $typoScript['sender.']['email.']) &&
            $this->cObj->cObjGetSingle($typoScript['sender.']['name'], $typoScript['sender.']['name.'])
        ) {
            $sender = [
                $this->cObj->cObjGetSingle($typoScript['sender.']['email'], $typoScript['sender.']['email.']) =>
                    $this->cObj->cObjGetSingle($typoScript['sender.']['name'], $typoScript['sender.']['name.'])
            ];
            $email->setFrom($sender);
        }
    }

    /**
     * Create and add an ics calender file as attachment
     *
     * @param MailMessage $email
     * @param \ChriWo\Staffholiday\Domain\Model\Plan $plan
     * @return void
     */
    protected function addIcsAttachment(&$email, $plan)
    {
        $properties = [
            'dtstart' => $plan->getHolidayBegin(),
            'dtend' => $plan->getHolidayEnd(),
            'description' => $plan->getNotice(),
            'summary' => LocalizationUtility::translate(
                'emailiCalSummary',
                'staffholiday',
                [
                    $plan->getUser()->getFirstName(),
                    $plan->getUser()->getLastName()
                ]
            )
        ];

        $icsService = $this->objectManager->get(IcsService::class, $properties);
        $icsService->set($properties);

        $email->attach(\Swift_Attachment::newInstance(
            $icsService->toString(),
            $properties['summary'],
            'text/calendar'
        ));
    }

    /**
     * Get path and filename for mail template.
     *
     * @param string $fileName
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @return string
     */
    protected function getRelativeEmailPathAndFilename($fileName)
    {
        return TemplateUtility::getTemplatePath('Email/' . ucfirst($fileName) . '.html');
    }
}
