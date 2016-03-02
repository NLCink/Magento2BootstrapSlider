<?php
/**
 *
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Api\Data;



use Magento\Framework\Api\ExtensibleDataInterface;
/**
 * Slideritems interface.
 * @api
 */
interface SlideritemsInterface extends ExtensibleDataInterface
{
	const SLIDERITEM_ID      	= 'slideritem_id';
	const SLIDERITEM_SLIDER		= 'slideritem_slider';
	const SLIDERITEM_TITLE		= 'slideritem_title';
	const SLIDERITEM_DESCRIPTION= 'slideritem_description';
	const SLIDERITEM_IMAGE_PATH = 'slider_image_path';
	const SLIDERITEM_IMAGE_MD_PATH = 'slider_image_md_path';
	const SLIDERITEM_IMAGE_SM_PATH = 'slider_image_sm_path';
	const SLIDERITEM_IMAGE_XS_PATH = 'slider_image_xs_path';
	const SLIDER_URL	      	= 'slider_url';
    const ISACTIVE	    		= 'is_active';
    const DATE					= 'date';
    const TIMESTAMP		 		= 'timestamp';
	const SLIDERITEM_SORT      	= 'slider_sort';
	const CAPTIONMETA	    	= 'captionmeta';
	
    /**
     * Get id
     *
     * @api
     * @return int|null
     */
    public function getId();
    /**
     * Get slider item
     *
     * @api
     * @return int|null
     */
    public function getSlideritemSlider();
    /**
     * Get Title
     *
     * @api
     * @return string|null
     */
    public function getSlideritemTitle();
    /**
     * Get Description
     *
     * @api
     * @return string|null
     */
    public function getSlideritemDescription();
    /**
     * Get SliderimagePath
     *
     * @api
     * @return string|null
     */
    public function getSliderImagePath();
    /**
     * Get SliderImageMdPath
     *
     * @api
     * @return string|null
     */
    public function getSliderImageMdPath();
    /**
     * Get SliderImageSmPath
     *
     * @api
     * @return string|null
     */
    public function getSliderImageSmPath();
    /**
     * Get SliderImageXsPath
     *
     * @api
     * @return string|null
     */
    public function getSliderImageXsPath();
    /**
     * Get SliderUrl
     *
     * @api
     * @return string|null
     */
    public function getSliderUrl();
    /**
     * Get Status
     *
     * @api
     * @return int|null
     */
    public function getIsActive();
    /**
     * Get Date
     *
     * @api
     * @return date|null
     */
    public function getDate();
    /**
     * Get Timestamp
     *
     * @api
     * @return timestamp|null
     */
    public function getTimestamp();
    /**
     * Get Sort
     *
     * @api
     * @return int|null
     */
    public function getSliderSort();
    /**
     * Get Caption
     *
     * @api
     * @return string|null
     */
    public function getCaptionmeta();

	/**
	* @return $this
	*/
    public function setId( $slideritem_id );
	/**
	* @return $this
	*/
    public function setSlideritemSlider( $slideritem_slider );
	/**
	* @return $this
	*/
    public function setSlideritemTitle( $slideritem_title );
	/**
	* @return $this
	*/
    public function setSlideritemDescription( $slideritem_description );
	/**
	* @return $this
	*/	
    public function setSliderImagePath( $slider_image_path );
	/**
	* @return $this
	*/
    public function setSliderImageMdPath( $slider_image_md_path );
	/**
	* @return $this
	*/
    public function setSliderImageSmPath( $slider_image_sm_path );
	/**
	* @return $this
	*/
    public function setSliderImageXsPath( $slider_image_xs_path );
	/**
	* @return $this
	*/
    public function setSliderUrl( $slider_url );
	/**
	* @return $this
	*/	
    public function setIsActive( $isactive );
	/**
	* @return $this
	*/
    public function setDate( $date );
	/**
	* @return $this
	*/
    public function setTimestamp( $timestamp );
	/**
	* @return $this
	*/
    public function setSliderSort( $slider_sort );
	/**
	* @return $this
	*/
    public function setCaptionmeta( $captionmeta );
}
