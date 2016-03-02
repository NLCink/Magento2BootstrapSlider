<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
 namespace Stepzerosolutions\Tbslider\Block;

use Stepzerosolutions\Tbslider\Model\Slider as SliderModel;
use Stepzerosolutions\Tbslider\Model\Templates\Fullwidth as Fullwidth;
/**
 * Slider blocks content block
 */
class Slider extends \Magento\Framework\View\Element\Template
 implements \Magento\Widget\Block\BlockInterface
{
	
	protected $_template = 'Stepzerosolutions_Tbslider::slider.phtml';
	
	
    /**
     * Registry object.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * slider collecion factory.
     *
     * @var \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\CollectionFactory
     */
    protected $_sliderFactory;
	
	
    /**
     * slider items collecion factory.
     *
     * @var \Stepzerosolutions\Tbslider\Model\Slider\Items\CollectionFactory
     */
    protected $slideritemsCollection;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;


    /**
     * @var \\Stepzerosolutions\Tbslider\Helper\Data
     */
    protected $_sliderHelper;
    /**
     * [__construct description].
     *
     * @param \Magento\Framework\View\Element\Template\Context                $context
     * @param \Magento\Framework\Registry                                     $coreRegistry
     * @param \Stepzerosolutions\Tbslider\Model\SliderFactory				  $sliderFactory
     * @param \Magento\Catalog\Model\CategoryFactory                          $categoryFactory
     * @param \Magento\Store\Model\StoreManagerInterface                      $storeManager
     * @param array                                                           $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Stepzerosolutions\Tbslider\Model\SliderFactory $sliderFactory,
        \Stepzerosolutions\Tbslider\Model\ResourceModel\Slider\Items\CollectionFactory $slideritemsCollection,
        \Stepzerosolutions\Tbslider\Helper\Data $sliderHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_sliderFactory = $sliderFactory;
        $this->_slideritemsCollection = $slideritemsCollection;

        $this->_scopeConfig = $context->getScopeConfig();
        $this->_storeManager = $context->getStoreManager();
		$this->_sliderHelper = $sliderHelper;
    }
	
	
    /**
     * Prepare block text and determine whether block output enabled or not
     * Prevent blocks recursion if needed
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();//die(var_dump( $this->getSliderId) );
        $sliderId = 1;
        if ($sliderId) {
            $storeId = $this->_storeManager->getStore()->getId();
            $slider = $this->_sliderFactory->create();
            $sliderData = $slider->load($sliderId);
			$sliderItemsData = $this->_slideritemsCollection->create()
			->addFieldToFilter( 'slideritem_slider', ['eq' => $sliderData->getId()] )
			->addFieldToFilter( 'is_active', ['eq' => 1] )
			->setOrder( 'slider_sort', 'desc' );
			$responsive = implode( ",", $slider->getResponsiveWidth() );

			if( $sliderData->getSliderType()==0 ) {
				$sliderTemplate = new Fullwidth($this->_storeManager);
			}
			$sliderTemplate->setSliderResponsiveData($responsive);
			$sliderTemplate->setSliderData($sliderData);
			$sliderTemplate->setSlideritems($sliderItemsData);
			
            if( $sliderData->getStatus()) {
				$output = $this->buildStyling($sliderData);
				$output .= '<div class="slidercontainer">';
				$output .= '<div class="slider_'.$sliderData->getID().'">';
				$output .= $sliderTemplate->renderSlider();
				$output .= '</div></div>';
				$output .= '
						<script type="text/javascript">
						require([\'jquery\',\'sz/tbslider\'], function($) {
						});
						</script>';
                $this->setText($output);
            }
        }
        return $this;
    }
	
	
    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();

        if ($this->_scopeConfig->getValue(
            SliderModel::XMLSLIDERSTATUS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store
        )
        ) {
			//return parent::_toHtml();
            return $this->getText();
        }

        return '';
    }
	
	public function buildStyling($sliderData){
		$slider = 'div.slider_'.$sliderData->getID().'{';
		$sliderwrap = '.slidercontainer{margin:0 auto;';
		$slideraftermaxwidth = '';
		if( !empty($sliderData->getSliderWidth() ) ) {
			if( strstr($sliderData->getSliderWidth(), "%")!=false ) {
				$sliderWidth = ( strstr($sliderData->getSliderWidth(), "px") )?$sliderData->getSliderWidth().'px':$sliderData->getSliderWidth();
			} else {
				$sliderWidth = $sliderData->getSliderWidth();
			}
			$slider .= sprintf( "width:%s;", $sliderWidth );
			$sliderwrap .= sprintf( "width:%s;", $sliderWidth );
			$slideraftermaxwidth .= '@media (max-width: '.$sliderWidth.'){.slidercontainer,div.slider_'.$sliderData->getID().'{width:100%;}}';
		} else {
			$slider .= "width:100%;";
			$sliderwrap .= "width:100%;";
		}
		if( !empty($sliderData->getSliderHeight() ) ) {
			if( strstr($sliderData->getSliderHeight(), "%")!=false ) {
				$sliderHeight = ( strstr($sliderData->getSliderHeight(), "px") )?$sliderData->getSliderHeight().'px':$sliderData->getSliderHeight();
			} else {
				$sliderHeight = $sliderData->getSliderHeight();
			}
			$slider .= sprintf( "height:%s;", $sliderHeight );
			$slider .= "overflow:hidden;";
		}
		$slider .= '}';
		$sliderwrap .= '}';
				
		$sliderItems = 'div.slider_'.$sliderData->getID().' .carousel-item{';
		if( !empty($sliderData->getSliderWidth() ) ) {
			$sliderItems .= "width:100%;";
		} 
		$sliderItems .= '}';
		 
		$mobileDevice = '@media (max-width: 768px){';
		$mobileDevice .= '.slidercontainer{';
		if( !empty($sliderData->getSliderWidthxs() ) ) {
			$mobileDeviceWidth = sprintf( "width:%dpx;", $sliderData->getSliderWidthxs() );
		} else {
			$mobileDeviceWidth = "width:100%;";
			$mobileDeviceWidth .= "max-width:768px;";
		}
		$mobileDevice .= $mobileDeviceWidth . '}';
		$mobileDevice .= 'div.slider_'.$sliderData->getID().'{';
		$mobileDevice .= $mobileDeviceWidth ;
		$mobileDevice .= 'height:auto;';
		$mobileDevice .= '}';
		$mobileDevice .= '}';
		
		
		$smallDevice = '@media (max-width: 922px){';
		$smallDevice .= '.slidercontainer{';
		if( !empty($sliderData->getSliderWidthsm() ) ) {
			$smallDeviceWidth = sprintf( "width:%dpx;", $sliderData->getSliderWidthsm() );
		} else {
			$smallDeviceWidth = "width:100%;";
			$smallDeviceWidth .= "max-width:922px;";
		}
		$smallDevice .= $smallDeviceWidth . '}';
		$smallDevice .= 'div.slider_'.$sliderData->getID().'{';
		$smallDevice .= $smallDeviceWidth ;
		$smallDevice .= 'height:auto;';
		$smallDevice .= '}';
		$smallDevice .= '}';
		
		
		$mediumDevice = '@media (max-width: 1024px){';
		$mediumDevice .= '.slidercontainer{';
		if( !empty($sliderData->getSliderWidthmd() ) ) {
			$mediumDeviceWidth = sprintf( "width:%dpx;", $sliderData->getSliderWidthmd() );
		} else {
			$mediumDeviceWidth = "width:100%;";
			$mediumDeviceWidth .= "max-width:1024px;";
		}
		$mediumDevice .= $mediumDeviceWidth . '}';
		$mediumDevice .= 'div.slider_'.$sliderData->getID().'{';
		$mediumDevice .= $mediumDeviceWidth ;
		$mediumDevice .= 'height:auto;';
		$mediumDevice .= '}';
		$mediumDevice .= '}';

		
		$output = '<style>';
		$output .= $sliderwrap . $slider . $sliderItems . $mediumDevice . $smallDevice . $mobileDevice .$slideraftermaxwidth;
		$output .= '</style>';
		return $output;
	}
}