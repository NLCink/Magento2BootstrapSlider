<?php
/**
 *
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Stepzerosolutions\Tbslider\Api\Data;


use Magento\Framework\Api\ExtensibleDataInterface;
/**
 * Slider interface.
 */
interface SliderInterface extends ExtensibleDataInterface
{
	const ID		     	= 'slider_id';
    const SLIDER_TITLE     	= 'slider_title';
    const SLIDER_DESCRIPTION= 'slider_description';
    const SLIDER_WIDTH     	= 'slider_width';
    const SLIDER_HEIGHT		= 'slider_height';
    const SLIDER_WIDTHXS	= 'slider_widthxs';
    const SLIDER_HEIGHTXS	= 'slider_heighthxs';
    const SLIDER_WIDTHSM	= 'slider_widthsm';
    const SLIDER_HEIGHTSM 	= 'slider_heightsm';
    const SLIDER_WIDTHMD	= 'slider_widthmd';
    const SLIDER_HEIGHTMD	= 'slider_heightmd';
    const SLIDER_CLASS		= 'slider_class';
    const SLIDER_BGCOLOR	= 'slider_bgcolor';
    const SLIDER_AUTORESPONSIVE= 'slider_autoresoponsive';
    const SLIDER_TYPE		= 'slider_type';
    const PAUSEONHOVER		= 'pauseonhover';
    const WRAP		  		= 'wrap';
    const KEYBOARD 			= 'keyboard';
    const SLIDERMETA		= 'slidermeta';
    const SLIDER_HIDEXS 	= 'slider_hidexs';
    const SLIDER_DURATION	= 'slider_duration';
    const DATE				= 'date';
    const STATUS	    	= 'status';
    const TIMESTAMP		 	= 'timestamp';
	const STORES		 	= 'stores';

    /**
     * Get id
     *
     * @api
     * @return int|null
     */
	public function getId();
    /**
     * Get Title
     *
     * @api
     * @return string|null
     */
    public function getSliderTitle();
    /**
     * Get Description
     *
     * @api
     * @return string|null
     */
    public function getSliderDescription();
    /**
     * Get Width
     *
     * @api
     * @return string|null
     */
    public function getSliderWidth();
    /**
     * Get Height
     *
     * @api
     * @return string|null
     */
    public function getSliderHeight();
    /**
     * Get WidthXS
     *
     * @api
     * @return string|null
     */
    public function getSliderWidthxs();
    /**
     * Get HeightXS
     *
     * @api
     * @return string|null
     */
    public function getSliderHeightxs();
    /**
     * Get WidthSM
     *
     * @api
     * @return string|null
     */
    public function getSliderWidthsm();
    /**
     * Get HeightSM
     *
     * @api
     * @return string|null
     */
    public function getSliderHeightsm();
    /**
     * Get WidthMD
     *
     * @api
     * @return string|null
     */
    public function getSliderWidthmd();
    /**
     * Get HeightMD
     *
     * @api
     * @return string|null
     */
    public function getSliderHeightmd();
    /**
     * Get SliderClass
     *
     * @api
     * @return string|null
     */
    public function getSliderClass();
    /**
     * Get BgColor
     *
     * @api
     * @return string|null
     */
    public function getSliderBgcolor();
    /**
     * Get SliderAutoresponsive
     *
     * @api
     * @return int|null
     */
    public function getSliderAutoresponsive();
    /**
     * Get SliderType
     *
     * @api
     * @return int|null
     */
    public function getSliderType();
    /**
     * Get Pausonhover
     *
     * @api
     * @return string|null
     */
    public function getPauseonhover();
    /**
     * Get Wrap
     *
     * @api
     * @return int|null
     */
    public function getWrap();
    /**
     * Get Keyboard
     *
     * @api
     * @return int|null
     */
    public function getKeyboard();
    /**
     * Get SliderMeta
     *
     * @api
     * @return string|null
     */
    public function getSlidermeta();
    /**
     * Get SliderMeta
     *
     * @api
     * @return string|null
     */
    public function getSliderHidexs();
    /**
     * Get SliderHidexs
     *
     * @api
     * @return int|null
     */
    public function getSliderDuration();
    /**
     * Get Date
     *
     * @api
     * @return date|null
     */
    public function getDate();
    /**
     * Get Status
     *
     * @api
     * @return int|null
     */
    public function getStatus();
    /**
     * Get Time
     *
     * @api
     * @return timestemp|null
     */
    public function getTimestamp();
	
    /**
     * Get Stores
     *
     * @api
     * @return text|null
     */
    public function getStores();
	
	
	/**
	* @return $this
	*/
    public function setId($slider_id);
	/**
	* @return $this
	*/
    public function setSliderTitle( $slider_title );
	/**
	* @return $this
	*/
    public function setSliderDescription( $slider_description );
	/**
	* @return $this
	*/
    public function setSliderWidth( $slider_width );
	/**
	* @return $this
	*/
    public function setSliderHeight( $slider_height );
	/**
	* @return $this
	*/
    public function setSliderWidthxs( $slider_widthxs );
	/**
	* @return $this
	*/
    public function setSliderHeightxs( $slider_heighthxs );
	/**
	* @return $this
	*/
    public function setSliderWidthsm( $slider_widthsm );
	/**
	* @return $this
	*/
    public function setSliderHeightsm( $slider_heightsm );
	/**
	* @return $this
	*/
    public function setSliderWidthmd( $slider_widthmd );
	/**
	* @return $this
	*/
    public function setSliderHeightmd( $slider_heightmd );
	/**
	* @return $this
	*/
    public function setSliderClass( $slider_class );
	/**
	* @return $this
	*/
    public function setSliderBgcolor( $slider_bgcolor );
	/**
	* @return $this
	*/
    public function setSliderAutoresponsive( $slider_autoresoponsive );
	/**
	* @return $this
	*/
    public function setSliderType( $slider_type );
	/**
	* @return $this
	*/
    public function setPauseonhover( $pauseonhover );
	/**
	* @return $this
	*/
    public function setWrap( $wrap );
	/**
	* @return $this
	*/
    public function setKeyboard( $keyboard );
	/**
	* @return $this
	*/
    public function setSlidermeta( $slidermeta );
	/**
	* @return $this
	*/
    public function setSliderHidexs( $slider_hidexs );
	/**
	* @return $this
	*/
    public function setSliderDuration( $slider_duration );
	/**
	* @return $this
	*/
    public function setDate( $date );
	/**
	* @return $this
	*/
    public function setStatus( $status );
	/**
	* @return $this
	*/
    public function setTimestamp( $timestamp );
	/**
	* @return $this
	*/
    public function setStores( $stores );
}
