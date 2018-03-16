<?php

namespace Narola\ProductService\Api\Data;

interface ServiceInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
    const LOGO = 'logo';
	const CONTENT = 'content';
    const PRICE = 'price';
    const PUBLISH_DATE = 'publish_date';
    const IS_ACTIVE = 'is_active';
    const UPDATE_TIME = 'update_time';
    const CREATED_AT = 'created_at';

   /**
    * Get EntityId.
    *
    * @return int
    */
    public function getEntityId();

   /**
    * Set EntityId.
    */
    public function setEntityId($entityId);

   /**
    * Get Title.
    *
    * @return varchar
    */
    public function getTitle();

   /**
    * Set Title.
    */
    public function setTitle($title);

	
	 /**
    * Get Logo.
    *
    * @return varchar
    */
    public function getLogo();

   /**
    * Set Title.
    */
    public function setLogo($logo);

	 /**
    * Get Price.
    *
    * @return varchar
    */
    public function getPrice();

   /**
    * Set Title.
    */
    public function setPrice($price);

	
   /**
    * Get Content.
    *
    * @return varchar
    */
    public function getContent();

   /**
    * Set Content.
    */
    public function setContent($content);

   /**
    * Get Publish Date.
    *
    * @return varchar
    */
    public function getPublishDate();

   /**
    * Set PublishDate.
    */
    public function setPublishDate($publishDate);

   /**
    * Get IsActive.
    *
    * @return varchar
    */
    public function getIsActive();

   /**
    * Set StartingPrice.
    */
    public function setIsActive($isActive);

   /**
    * Get UpdateTime.
    *
    * @return varchar
    */
    public function getUpdateTime();

   /**
    * Set UpdateTime.
    */
    public function setUpdateTime($updateTime);

   /**
    * Get CreatedAt.
    *
    * @return varchar
    */
    public function getCreatedAt();

   /**
    * Set CreatedAt.
    */
    public function setCreatedAt($createdAt);
}
