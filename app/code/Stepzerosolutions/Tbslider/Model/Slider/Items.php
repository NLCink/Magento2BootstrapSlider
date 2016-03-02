<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Model\Slider;

use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterface;

/**
 * @stepzerosolutions
 */
class Items  extends \Magento\Framework\Model\AbstractModel
implements SlideritemsInterface
{
    /**
     * CMS block cache tag
     */
    const CACHE_TAG = 'tbslider';

    /**
     * @var string
     */
    protected $_cacheTag = 'tbslider';
	
/**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'tbslider';

 /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items');
    }
	public function getId(){
		return $this->getData(self::SLIDERITEM_ID);
	}
    public function getSlideritemSlider(){
		return $this->getData(self::SLIDERITEM_SLIDER);
	}
    public function getSlideritemTitle(){
		return $this->getData(self::SLIDERITEM_TITLE);
	}
    public function getSlideritemDescription(){
		return $this->getData(self::SLIDERITEM_DESCRIPTION);
	}
    public function getSliderImagePath(){
		return $this->getData(self::SLIDERITEM_IMAGE_PATH);
	}
    public function getSliderImageMdPath(){
		return $this->getData(self::SLIDERITEM_IMAGE_MD_PATH);
	}
    public function getSliderImageSmPath(){
		return $this->getData(self::SLIDERITEM_IMAGE_SM_PATH);
	}
    public function getSliderImageXsPath(){
		return $this->getData(self::SLIDERITEM_IMAGE_XS_PATH);
	}
    public function getSliderUrl(){
		return $this->getData(self::SLIDER_URL);
	}
    public function getIsActive(){
		return $this->getData(self::ISACTIVE);
	}
    public function getDate(){
		return $this->getData(self::DATE);
	}
    public function getTimestamp(){
		return $this->getData(self::TIMESTAMP);
	}
    public function getSliderSort(){
		return $this->getData(self::SLIDERITEM_SORT);
	}
    public function getCaptionmeta(){
		return $this->getData(self::CAPTIONMETA);
	}
	
	//set values
	
	public function setId($slideritemid){
		return $this->setData( self::SLIDERITEM_ID, $slideritemid );
	}
    public function setSlideritemSlider( $slideritemslider ){
		return $this->setData( self::SLIDERITEM_SLIDER, $slideritemslider );
	}
    public function setSlideritemTitle( $itemtitle ){
		return $this->setData( self::SLIDERITEM_TITLE, $itemtitle );
	}
    public function setSlideritemDescription( $description ){
		return $this->setData( self::SLIDERITEM_DESCRIPTION, $description );
	}
    public function setSliderImagePath( $imagepath ){
		return $this->setData( self::SLIDERITEM_IMAGE_PATH, $imagepath );
	}
    public function setSliderImageMdPath( $imagemdpath ){
		return $this->setData( self::SLIDERITEM_IMAGE_MD_PATH, $imagemdpath );
	}
    public function setSliderImageSmPath( $imagesmpath ){
		return $this->setData( self::SLIDERITEM_IMAGE_SM_PATH, $imagesmpath );
	}
    public function setSliderImageXsPath( $imagexspath ){
		return $this->setData( self::SLIDERITEM_IMAGE_XS_PATH, $imagexspath );
	}
    public function setSliderUrl( $sliderurl ){
		return $this->setData( self::SLIDER_URL, $sliderurl );
	}
    public function setIsActive( $isactive ){
		return $this->setData( self::ISACTIVE, $isactive );
	}
    public function setDate( $date ){
		return $this->setData( self::DATE, $date );
	}
    public function setTimestamp( $timestamp ){
		return $this->setData( self::TIMESTAMP, $timestamp );
	}
    public function setSliderSort( $slidersort ){
		return $this->setData( self::SLIDERITEM_SORT, $slidersort );
	}
    public function setCaptionmeta( $captionmeta ){
		return $this->setData( self::CAPTIONMETA, $captionmeta );
	}
}
