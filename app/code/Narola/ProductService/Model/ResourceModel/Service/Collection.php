<?php

namespace Narola\ProductService\Model\ResourceModel\Service;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'Narola\ProductService\Model\Service',
            'Narola\ProductService\Model\ResourceModel\Service'
        );
    }
}
