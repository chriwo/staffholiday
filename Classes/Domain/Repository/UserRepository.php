<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
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
