<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace Mediaopt\DHL\ServiceProvider;


use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

/**
 * This class encapsulates information about a service provider.
 *
 * @author  Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL\ServiceProvider
 */
class ServiceInformation
{

    /**
     * @var ServiceType[]
     */
    protected $serviceTypes;

    /**
     * @var Timetable
     */
    protected $timetable;

    /**
     * The key is a ISO 639-1, the value the corresponding remark.
     *
     * @var string[]
     */
    protected $remark;

    /**
     * @param Timetable     $timetable
     * @param ServiceType[] $serviceTypes
     * @param array         $remark
     */
    public function __construct(Timetable $timetable, array $serviceTypes, array $remark = [])
    {
        $this->timetable = $timetable;
        $this->setServiceTypes($serviceTypes);
        $this->remark = $remark;
    }

    /**
     * @param string $languageIsoCode
     * @return string
     */
    public function getRemark($languageIsoCode)
    {
        return array_key_exists($languageIsoCode, $this->remark)
            ? $this->remark[$languageIsoCode]
            : '';
    }

    /**
     * @param string $languageIsoCode
     * @param string $remark
     */
    public function setRemark($languageIsoCode, $remark)
    {
        $this->remark[$languageIsoCode] = $remark;
    }

    /**
     * @return \string[]
     */
    public function getRemarkInEachLanguage()
    {
        return $this->remark;
    }

    /**
     * @return ServiceType[]
     */
    public function getServiceTypes()
    {
        return $this->serviceTypes;
    }

    /**
     * @param ServiceType[] $serviceTypes
     */
    public function setServiceTypes($serviceTypes)
    {
        $sortFn = function (ServiceType $serviceType1, ServiceType $serviceType2) {
            return strcmp($serviceType1->getName(), $serviceType2->getName());
        };
        usort($serviceTypes, $sortFn);
        $this->serviceTypes = $serviceTypes;
    }

    /**
     * @return Timetable
     */
    public function getTimetable()
    {
        return $this->timetable;
    }

    /**
     * @param Timetable $timetable
     */
    public function setTimetable($timetable)
    {
        $this->timetable = $timetable;
    }

}
