<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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
 * Class UserRepository.
 */
class UserRepository extends FrontendUserRepository
{
    /**
     * Find users by comma-separated user group list.
     *
     * @param string $userGroupList comma.separated list of user group uid
     * @param array $settings Flexform and TypoScript Settings
     * @param array $filter Filter Array
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByUsergroups($userGroupList, $settings, $filter)
    {
        $query = $this->createQuery();

        $and = [
            $query->greaterThan('uid', 0),
        ];

        if (!empty($userGroupList)) {
            $selectedUsergroups = GeneralUtility::trimExplode(',', $userGroupList, true);
            $logicalOr = [];
            foreach ($selectedUsergroups as $group) {
                $logicalOr[] = $query->contains('usergroup', $group);
            }
            $and[] = $query->logicalOr($logicalOr);
        }

        if (!empty($filter['searchword'])) {
            $searchWords = GeneralUtility::trimExplode(' ', $filter['searchword'], true);
            $fieldsToSearch = GeneralUtility::trimExplode(
                ',',
                $settings['list']['filter']['searchword']['fieldsToSearch'],
                true
            );
            foreach ($searchWords as $searchWord) {
                $logicalOr = [];
                foreach ($fieldsToSearch as $searchfield) {
                    $logicalOr[] = $query->like($searchfield, '%' . $searchWord . '%');
                }
                $and[] = $query->logicalOr($logicalOr);
            }
        }
        $query->matching($query->logicalAnd($and));

        $sorting = QueryInterface::ORDER_ASCENDING;
        if ($settings['list']['sorting'] === 'desc') {
            $sorting = QueryInterface::ORDER_DESCENDING;
        }
        $field = preg_replace('/[^a-zA-Z0-9_-]/', '', $settings['list']['orderby']);
        $query->setOrderings([$field => $sorting]);

        if ((int) $settings['list']['limit'] > 0) {
            $query->setLimit((int) $settings['list']['limit']);
        }

        return $query->execute();
    }
}
