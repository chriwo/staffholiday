<?php
namespace ChriWo\Staffholiday\Utility;

use ChriWo\Staffholiday\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class UserUtility.
 */
class UserUtility extends AbstractUtility
{
    /**
     * Return current logged in fe_user.
     *
     * @return null|object|\ChriWo\Staffholiday\Domain\Model\User
     */
    public static function getCurrentUser()
    {
        if (null !== self::getPropertyFromUser()) {
            /** @var UserRepository $userRepository */
            $userRepository = GeneralUtility::makeInstance(ObjectManager::class)->get(UserRepository::class);

            return $userRepository->findByUid((int) self::getPropertyFromUser());
        }

        return null;
    }

    /**
     * Get property from current logged in Frontend User.
     *
     * @param string $propertyName
     * @return string|null
     */
    public static function getPropertyFromUser($propertyName = 'uid')
    {
        if (!empty(self::getTypoScriptFrontendController()->fe_user->user[$propertyName])) {
            return self::getTypoScriptFrontendController()->fe_user->user[$propertyName];
        }

        return null;
    }

    /**
     * Get UserGroups from current logged in user.
     *
     * @return array
     */
    public static function getCurrentUserGroupUids()
    {
        $currentLoggedInUser = self::getCurrentUser();
        $userGroupUid = [];
        if (null !== $currentLoggedInUser) {
            foreach ($currentLoggedInUser->getUsergroup() as $userGroup) {
                $userGroupUid[] = $userGroup->getUid();
            }
        }

        return $userGroupUid;
    }
}
