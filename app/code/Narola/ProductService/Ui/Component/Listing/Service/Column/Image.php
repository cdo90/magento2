<?php

namespace Narola\ProductService\Ui\Component\Listing\Service\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Narola\ProductService\Model\Service as ServiceModel;

class Image extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'image';

    const ALT_FIELD = 'name';

    /**
     * @param \Magento\Framework\Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /** @var brandModel */
    protected $serviceModel;

    /**
     * @param ContextInterface                           $context            
     * @param UiComponentFactory                         $uiComponentFactory 
     * @param \Magento\Catalog\Helper\Image              $imageHelper        
     * @param \Magento\Framework\UrlInterface            $urlBuilder         
     * @param \Magento\Framework\Filesystem              $filesystem         
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager       
     * @param BrandModel                                 $brandModel         
     * @param array                                      $components         
     * @param array                                      $data               
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ServiceModel $serviceModel,
        array $components = [],
        array $data = []
        ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->filesystem = $filesystem;
        $this->_storeManager = $storeManager;
        $this->serviceModel = $serviceModel;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {

        /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $mediaFolder = 'service/logo/';

        $path = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        if (isset($dataSource['data']['items']))
        {    
	
            $fieldName = $this->getData('name');
			
            foreach ($dataSource['data']['items'] as &$item) {
                if(!isset($item['logo'])) continue;
				
				
                if($item['logo']){
                    $imageUrl = $path.$item['logo'];
                    $item[$fieldName . '_src'] = $imageUrl;
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        'product/service/addrow/',
                        ['id' => $item['entity_id'], 'store' => $this->context->getRequestParam('store')]
                        );
                    $item[$fieldName . '_orig_src'] = $imageUrl;
                }
            }
        }
        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
