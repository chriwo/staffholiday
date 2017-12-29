<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
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
 * Class PlanRepository.
 */
class PlanRepository extends AbstractRepository
{
    /**
     * Find all years of holiday plans.
     *
     * @param bool $excludeExpiredPlan
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findYears($excludeExpiredPlan = false)
    {
        $excludeWhere = '';

        if ($excludeExpiredPlan) {
            $currentDate = new \DateTime('now');
            $excludeWhere = ' AND plan.holiday_end > ' . $currentDate->getTimestamp();
        }

        $query = $this->createQuery();
        $query->statement(
            'SELECT 
              FROM_UNIXTIME(plan.holiday_begin, \'%Y\') as years
			FROM 
			  tx_staffholiday_domain_model_plan AS plan 
			WHERE 
			  plan.deleted=0 AND plan.hidden=0 ' . $excludeWhere . '
			GROUP BY 
			  years 
			ORDER BY 
			  years desc'
        );

        return $query->execute(true);
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
        $object = $query->matching($query->logicalAnd($and))->execute()->getFirst();

        return $object;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param $settings
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
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
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param $userGroupList
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
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
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\ComparisonInterface
     */
    protected function createExcludeExpiredPlanContrain(QueryInterface $query)
    {
        $currentDate = new \DateTime('now');

        return $query->greaterThan('holidayEnd', $currentDate->getTimestamp());
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param int $year
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
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
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param $filter
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
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
