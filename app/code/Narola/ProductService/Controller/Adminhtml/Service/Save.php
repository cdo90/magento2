<?php

namespace Narola\ProductService\Controller\Adminhtml\Service;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\Grid\Model\GridFactory
     */
    var $serviceFactory;

	/**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Webkul\Grid\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Narola\ProductService\Model\ServiceFactory $serviceFactory
    ) {
        parent::__construct($context);
		$this->serviceFactory = $serviceFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
		$resultRedirect = $this->resultRedirectFactory->create();
        if (!$data) {
            $this->_redirect('product/service/addrow');
            return;
        }
        try {
            $rowData = $this->serviceFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
			
			/* ======================================== */
			
			/** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
            $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
            ->getDirectoryRead(DirectoryList::MEDIA);
			$mediaFolder= "";
			if(isset($data['logo']['value'])){
				$mediaFolder = $data['logo']['value'];
			}
            
			// Delete, Upload Image
            $imagePath = $mediaDirectory->getAbsolutePath($mediaFolder);
			
            if(isset($data['logo']['delete']) && file_exists($imagePath)){
                unlink($imagePath);
                $data['logo'] = '';
            }
            if(isset($data['logo']) && is_array($data['logo'])){
                unset($data['logo']);
            }
            if($image = $this->uploadImage('logo')){
                
                $data['logo'] = $image;
            }
			
		    $links = $this->getRequest()->getPost('links');
            $links = is_array($links) ? $links : [];
            if(!empty($links) && isset($links['related'])){
                $products = $this->jsHelper->decodeGridSerializedInput($links['related']);
                $data['products'] = $products;
            }
			
            $rowData->setData($data);
            try {
                $rowData->save();
                $this->messageManager->addSuccess(__('You saved this Product Service.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/addrow', ['id' => $rowData->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the brand.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/addrow', ['id' => $this->getRequest()->getParam('id')]);
			
			/* ======================================== */
			
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('product/service/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Narola_ProductService::save');
    }
	
	public function uploadImage($fieldId = 'logo')
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if (isset($_FILES[$fieldId]) && $_FILES[$fieldId]['name']!='') 
        {
            $uploader = $this->_objectManager->create(
                'Magento\Framework\File\Uploader',
                array('fileId' => $fieldId)
                );
           

                /** @var \Magento\Framework\Filesystem\Directory\Read $mediaDirectory */
                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')
                ->getDirectoryRead(DirectoryList::MEDIA);
                $mediaFolder = 'service/logo/';
                try {
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); 
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $result = $uploader->save($mediaDirectory->getAbsolutePath($mediaFolder));
                    return $mediaFolder.$result['name'];
                } catch (\Exception $e) {
                    $this->_logger->critical($e);
                    $this->messageManager->addError($e->getMessage());
                  //  return $resultRedirect->setPath('*/*/edit', ['brand_id' => $this->getRequest()->getParam('brand_id')]);
				  //$this->_redirect('product/service/index');
				  echo "some thing wrong check in code file (save.php)";
				  die;
                }
            }
            return;
        }
}
