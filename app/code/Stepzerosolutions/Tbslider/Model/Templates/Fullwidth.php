<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Model\Templates;

use Stepzerosolutions\Tbslider\Api\Data\TemplatesInterface as TemplatesInterface;
/**
 * @stepzerosolutions
 */
class Fullwidth 
implements TemplatesInterface
{
	protected $_sliderdata;
	protected $_sliderItems;
	protected $_storeManager;
	protected $_sliderResponsive;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

	public function getSliderResponsiveData(){
		return $this->_sliderResponsive;
	}
	
	public function setSliderResponsiveData($_sliderResponsive){
		$this->_sliderResponsive = $_sliderResponsive;
	}
	
	
	public function getSliderData(){
		return $this->_sliderdata;
	}
	
	public function setSliderData($sliderdata){
		$this->_sliderdata = $sliderdata;
	}
	
	public function getSlideritems(){
		return $this->_sliderItems;
	}
	
	public function setSlideritems($items){
		$this->_sliderItems = $items;
	}
	
	public function renderSlider(){
		$cid='generic_slider';
		$output = '';
		$first=true;
		$slidto = 0;
		$ol = '<ol class="carousel-indicators">';
		foreach( $this->getSlideritems() as $slide ){
			$slider = $slide->getData();
				$ol .= '<li data-target="#'.$cid.'" data-slide-to="'.$slidto.'"';
				$slidto++;
				if( $first ) $ol .= ' class="active"';
				$ol .= ' ></li>

				';
				$url = !empty($slider['slider_url'])?'<a href="'.$slider['slider_url'].'" title="'.$slider['slideritem_title'].'">':'';
				$urlend = !empty($slider['slider_url'])?'</a>':'';
				$output .= '<div class="item ';
				if( $first ) { $output .= 'active'; $first=false; }
				$output .= '">';
				$default = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . $slide->getSliderImagePath();
				$filename = $default;
				$filenamemd = ( !empty($slide->getSliderImageMdPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . 
				$slide->getSliderImageMdPath():$default;
				$filenamesm = ( !empty($slide->getSliderImageSmPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . 
				$slide->getSliderImageSmPath():$default;
				$filenamexs = ( !empty($slide->getSliderImageXsPath()) )?$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ) . 
				$slide->getSliderImageXsPath():$default;
				$responsive = $this->getSliderResponsiveData();			

				$output .= $url.'<img class="sztbslider" data-src="'.$filename.'" 
				data-smsrc="'.$filenamesm.'" data-mdsrc="'.$filenamemd.'"  data-xssrc="'.$filenamexs.'" 
				alt="'.$slider['slideritem_title'].'" width="100%" />'.$urlend;
				
				if( ! empty( $slider['slideritem_description'] ) ){
					$output .= '<div class="carousel-caption">
									';
					$output .= $slider['slideritem_description'];
    	            $output .= '	';
	                $output .= '   </div>';
				}
                $output .= '</div>';
				
		}
		$ol .= '</ol>';
		if( empty( $output ) ) return false;
		
		$outputRender = '<div id="'.$cid.'" class="carousel slide" data-ride="carousel">';
		$cssClass = ( !empty($this->_sliderdata->getSliderClass()) )?$this->_sliderdata->getSliderClass():'';
		$dataInterval = ( !empty($this->_sliderdata->getSliderDuration()) )?$this->_sliderdata->getSliderDuration():5000;
		$dataWrap = ( !empty($this->_sliderdata->getWrap()) )?$this->_sliderdata->getWrap():true;
		$dataKeyboard = ( !empty($this->_sliderdata->getKeyboard()) )?$this->_sliderdata->getKeyboard():true;
		$dataPause = ( !empty($this->_sliderdata->getPauseonhover()) )?"hover":"false";
		
		$outputRender .= '<div class="carousel-inner szcarousel '.$cssClass.'" 
										data-interval="'.$dataInterval.'" 
										data-wrap="'.$dataWrap.'" 
										data-keyboard="'.$dataKeyboard.'" 
										data-pause="'.$dataPause.'" 
										role="listbox" 
										data-responsivewidth="'.$responsive.'" >
					' . $ol . $output . '
					</div>';
		if( count( $this->_sliderItems->getData() )>1 ) {
			$outputRender .= '
				 <!-- Controls -->
				  <a class="left carousel-control" href="#'.$cid.'" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#'.$cid.'" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
			';
		}
		$outputRender .= '</div>';

		return $outputRender;
	}
}
