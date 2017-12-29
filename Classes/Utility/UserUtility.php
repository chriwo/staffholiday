<?php
namespace ChriWo\Staffholiday\Utility;

use In2code\Femanager\Domain\Model\User;
use In2code\Femanager\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
 * Class UserUtility.
 */
class UserUtility extends AbstractUtility
{
    /**
     * Return current logged in fe_user.
     *
     * @return User|null
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
