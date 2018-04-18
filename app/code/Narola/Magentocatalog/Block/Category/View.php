<?php
/**
 * Narola
 * @package  Narola_Magentocatalog
 * 
 */
namespace Narola\Magentocatalog\Block\Category;

class View extends \Magento\Catalog\Block\Category\View
{
	/**
     * Product collection model
     *
     * @var Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
    */
	protected $_productCollectionFactory;
	
	/**
     * Product collection model
     *
     * @var Magento\Catalog\Model\CategoryFactory
    */
	protected $_categoryFactory;
	
	
	 /**
     * Initialize
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
	 * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
	 * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver
	 * @param \Magento\Framework\Registry $registry
	 * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param array $data
     */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
		\Magento\Catalog\Model\CategoryFactory $categoryFactory,
		\Magento\Catalog\Model\Layer\Resolver $layerResolver,
		\Magento\Framework\Registry $registry,
		\Magento\Catalog\Helper\Category $categoryHelper,
		array $data = []
    ) {
    	$this->_categoryFactory = $categoryFactory;
		$this->_productCollectionFactory = $productCollectionFactory;
		parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
    }
	
	 /**
     * Get subcategory collection
     */
	public function getSubcategory($catId)	
    {
		$objectManagerr = \Magento\Framework\App\ObjectManager::getInstance();
		$categoryFactory = $objectManagerr->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
		$collection = $categoryFactory->create()
		->addFieldToFilter('parent_id', $catId)	
		->addAttributeToSelect('*');
		return $collection;
	}
	
	 /**
     * Get product collection by categoryID
     */
	public function  getSubcategory_product($sub_catid){
		$category = $this->_categoryFactory->create()->load($sub_catid);
		$collection = $this->_productCollectionFactory->create();
		$collection->addAttributeToSelect('*');
		$collection->addCategoryFilter($category);
		$collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
		$collection->addAttributeToFilter('status',\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
		return $collection;
	}
}
