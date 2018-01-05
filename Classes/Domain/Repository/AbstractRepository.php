<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***************************************************************
 *
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
 * Class AbstractRepository.
 */
abstract class AbstractRepository extends Repository
{
    /**
     * @param array $settings
     * @param bool|true $respectEnableFields
     * @return mixed
     */
    public function findDemanded($settings, $respectEnableFields = true)
    {
        $query = $this->generateQuery($settings, $respectEnableFields);

        return $query->execute();
    }

    /**
     * Function to build the query and return an QueryInferface object of the
     * matching demand.
     *
     * @param array $settings
     * @param bool|true $respectEnableFields
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    protected function generateQuery($settings, $respectEnableFields = true)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraints = $this->createContrainsFromSettings($query, $settings);

        if (false === $respectEnableFields) {
            $query->getQuerySettings()->setIgnoreEnableFields(true);
            $constraints[] = $query->equals('deleted', 0);
        }

        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }

        if ($orderings = $this->createOrderingsFromSettings($settings)) {
            $query->setOrderings($orderings);
        }

        if (intval($settings['list']['limit'])) {
            $query->setLimit((int) $settings['list']['limit']);
        }

        return $query;
    }

    /**
     * Abstract function to create the constraints of given demand object.
     *
     * @param QueryInterface $query
     * @param array $settings
     * @return array
     */
    abstract protected function createContrainsFromSettings(QueryInterface $query, $settings);

    /**
     * Abstract function to create the ordering of given demand object.
     *
     * @param array $settings
     * @return mixed
     */
    abstract protected function createOrderingsFromSettings($settings);
}
