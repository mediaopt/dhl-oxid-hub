<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Export;

/**
 * Each class that implements this interface is able to export.
 *
 * @author Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package ${NAMESPACE}
 */
interface Exporter
{

    /**
     * @param array $entities
     * @return $this
     */
    public function export(array $entities);

    /**
     * @return string
     */
    public function save();

}
