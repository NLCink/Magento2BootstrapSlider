<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Sitemap data helper
 *
 */
namespace Stepzerosolutions\Tbslider\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
	
    /**
     * category collection factory.
     *
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * [__construct description].
     *
     * @param \Magento\Framework\App\Helper\Context                      $context              [description]
     * @param \Magento\Directory\Helper\Data                             $directoryData        [description]
     * @param \Magento\Directory\Model\ResourceModel\Country\Collection       $countryCollection    [description]
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regCollectionFactory [description]
     * @param \Magento\Store\Model\StoreManagerInterface                 $storeManager         [description]
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->_storeManager = $storeManager;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }
	
    /**
     * get Base Url Media Slider.
     *
     * @param string $path   [description]
     * @param bool   $secure [description]
     *
     * @return string [description]
     */
    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) .'slider'. $path;
    }
	
	

	public function getSliderTypeName(){
		return array( '0' => __('Full Width'), '1' => __('Slider Type 1'), '2' => __('Slider Type 2') );
	}
	
	
}
