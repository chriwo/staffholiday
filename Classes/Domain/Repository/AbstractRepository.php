<?php
namespace ChriWo\Staffholiday\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * This file is part of the "staffholiday" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

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
