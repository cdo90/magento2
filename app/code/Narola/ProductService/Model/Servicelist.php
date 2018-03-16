<?php

namespace Narola\ProductService\Model;

class Servicelist extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected  $_service;
    
    /**
     * 
     * @param \Ves\Brand\Model\Brand $brand
     */
    public function __construct(
        \Narola\ProductService\Model\Service $service
        ) {
        $this->_service = $service;
    }
    
    
    /**
     * Get Gift Card available templates
     *
     * @return array
     */
    public function getAvailableTemplate()
    {
        $services = $this->_service->getCollection()
        ->addFieldToFilter('is_active', '1');
        $listService = array();
        foreach ($services as $service) {
            $listService[] = array('label' => $service->getTitle(),
                'value' => $service->getEntityId());
        }
		
		return $listService;
    }

    /**
     * Get model option as array
     *
     * @return array
     */
    public function getAllOptions($withEmpty = true)
    {		
        $options = array();
        $options = $this->getAvailableTemplate();

        if ($withEmpty) {
            array_unshift($options, array(
                'value' => '',
                'label' => '-- Please Select --',
                ));
        }
		
        return $options;
    }
}