<?php

namespace Narola\ProductService\Model;

use Narola\ProductService\Api\Data\ServiceInterface;

class Service extends \Magento\Framework\Model\AbstractModel implements ServiceInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'narola_product_service_records';

    /**
     * @var string
     */
    protected $_cacheTag = 'narola_product_service_records';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'narola_product_service_records';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Narola\ProductService\Model\ResourceModel\Service');
    }
    /**
     * Get EntityId.
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set EntityId.
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get Title.
     *
     * @return varchar
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set Title.
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

	 /**
     * Get Logo.
     *
     * @return varchar
     */
    public function getLogo()
    {
        return $this->getData(self::LOGO);
    }

    /**
     * Set Logo.
     */
    public function setLogo($logo)
    {
        return $this->setData(self::LOGO, $logo);
    }
	
	
	 /**
     * Get Price.
     *
     * @return varchar
     */
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    /**
     * Set Price.
     */
    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

	
    /**
     * Get getContent.
     *
     * @return varchar
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set Content.
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Get PublishDate.
     *
     * @return varchar
     */
    public function getPublishDate()
    {
        return $this->getData(self::PUBLISH_DATE);
    }

    /**
     * Set PublishDate.
     */
    public function setPublishDate($publishDate)
    {
        return $this->setData(self::PUBLISH_DATE, $publishDate);
    }

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set IsActive.
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get UpdateTime.
     *
     * @return varchar
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set UpdateTime.
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
