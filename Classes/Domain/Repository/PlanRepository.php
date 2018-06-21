<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use ChriWo\Staffholiday\Utility\ObjectUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
 * Class PlanRepository.
 */
class PlanRepository extends AbstractRepository
{
    const TABLE = 'tx_staffholiday_domain_model_plan';

    /**
     * Find all years of holiday plans.
     *
     * @param bool $excludeExpiredPlan
     * @return array
     */
    public function findYears($excludeExpiredPlan = false)
    {
        $queryBuilder = ObjectUtility::getConnectionPool()->getQueryBuilderForTable(self::TABLE);

        if ($excludeExpiredPlan) {
            $currentDate = new \DateTime('now');
            $queryBuilder->where(
                $queryBuilder->expr()->gt('holiday_end', $currentDate->getTimestamp())
            );
        }

        return $queryBuilder
            ->addSelectLiteral('FROM_UNIXTIME(holiday_begin, \'%Y\') as years')
            ->from(self::TABLE)
            ->orderBy('years', 'DESC')
            ->groupBy('years')
            ->execute()
            ->fetchAll();
    }

    /**
     * Overload Find by UID to also get hidden records.
     *
     * @param int $uid plan UID
     * @return \ChriWo\Staffholiday\Domain\Model\Plan|object
     */
    public function findByUid($uid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setRespectStoragePage(false);
        $and = [
            $query->equals('uid', $uid),
            $query->equals('deleted', 0),
        ];

        return $query->matching($query->logicalAnd($and))->execute()->getFirst();
    }

    /**
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $settings
     * @return array
     */
    protected function createContrainsFromSettings(QueryInterface $query, $settings)
    {
        $constraints = [];

        if (!empty($settings['list']['usergroup'])) {
            $constraints['usergroups'] = $this->createUserGroupConstrain($query, $settings['list']['usergroup']);
        }

        if ($settings['list']['user']) {
            unset($constraints['usergroups']);
            $constraints['user'] = $query->equals('user', $settings['list']['user']);
        }

        if ($settings['list']['excludeExpiredPlans']) {
            $constraints['excludeExpiredPlans'] = $this->createExcludeExpiredPlanContrain($query);
        }

        if ((int) $settings['list']['filter']['year']) {
            $constraints['year'] = $this->createYearConstrain($query, (int) $settings['list']['filter']['year']);
        }

        if (!empty($settings['list']['filter']['searchword'])) {
            $constraints['searchWord'] = $this->createSearchConstrain($query, $settings['list']['filter']);
        }

        // Clean not used constraints
        foreach ($constraints as $key => $value) {
            if (is_null($value)) {
                unset($constraints[$key]);
            }
        }

        return $constraints;
    }

    /**
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param string $userGroupList Comma-separated list of user group uid
     * @return null|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface
     */
    protected function createUserGroupConstrain(QueryInterface $query, $userGroupList)
    {
        $constraint = null;

        if (!empty($userGroupList)) {
            $selectedUserGroups = GeneralUtility::trimExplode(',', $userGroupList, true);
            $logicalOr = [];

            foreach ($selectedUserGroups as $group) {
                $logicalOr[] = $query->contains('user.usergroup', $group);
            }
            $constraint = $query->logicalOr($logicalOr);
        }

        return $constraint;
    }

    /**
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface
     */
    protected function createExcludeExpiredPlanContrain(QueryInterface $query)
    {
        $currentDate = new \DateTime('now');

        return $query->greaterThan('holidayEnd', $currentDate->getTimestamp());
    }

    /**
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param int $year
     * @return null|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\AndInterface
     */
    protected function createYearConstrain(QueryInterface $query, $year)
    {
        $constraint = null;

        if ($year) {
            $lowestDate = new \DateTime($year . '-1-1 00:00:00');
            $highestDate = new \DateTime($year . '-12-31 23:59:59');

            $constraint = $query->logicalAnd(
                [
                    $query->lessThanOrEqual('holidayBegin', $highestDate->getTimestamp()),
                    $query->greaterThanOrEqual('holidayBegin', $lowestDate->getTimestamp()),
                ]
            );
        }

        return $constraint;
    }

    /**
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $filter
     * @return null|\TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface
     */
    protected function createSearchConstrain(QueryInterface $query, $filter)
    {
        $constrain = null;

        if (!empty($filter['searchword'])) {
            $searchWords = GeneralUtility::trimExplode(' ', $filter['searchword'], true);
            $fieldsToSearch = GeneralUtility::trimExplode(
                ',',
                $filter['fieldsToSearch'],
                true
            );

            $logicalOr = [];
            foreach ($searchWords as $searchWord) {
                foreach ($fieldsToSearch as $searchField) {
                    $logicalOr[] = $query->like($searchField, '%' . $searchWord . '%');
                }
            }

            $constrain = $query->logicalOr($logicalOr);
        }

        return $constrain;
    }

    /**
     * Create the ordering.
     *
     * @param array $settings
     * @return array
     */
    protected function createOrderingsFromSettings($settings)
    {
        $orderings = [];

        if (!empty($settings['list']['orderby'])) {
            $orderField = $settings['list']['orderby'];
            $orderings[$orderField] = (('desc' === strtolower($settings['list']['sorting'])) ?
                    QueryInterface::ORDER_DESCENDING :
                    QueryInterface::ORDER_ASCENDING);
        }

        return $orderings;
    }
}
