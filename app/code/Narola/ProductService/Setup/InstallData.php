<?php
namespace Narola\ProductService\Setup;

use Narola\ProductService\Model\Service;
use Narola\ProductService\Model\ServiceFactory;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
	private $serviceFactory;

    public function __construct(EavSetupFactory $eavSetupFactory, ServiceFactory $serviceFactory )
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->serviceFactory = $serviceFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'product_service_attribute',
            [				
				'group' => 'Product Services',
				'type' => 'varchar',
				'label' => 'Product Recomanded Services',
				'input' => 'multiselect',
				'required' => false,
				'sort_order' => 4,
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				'is_html_allowed_on_front' => true,
				'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
				'source' => 'Narola\ProductService\Model\Servicelist',
            ]
        );
    }
}