<?php
/**
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Block\Adminhtml\Block\Grid\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
	protected $_imageprocessor;
	
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $_storeManager;
	
	
    public function __construct(
		\Stepzerosolutions\Tbslider\Model\Image $imageprocessor,
		\Magento\Framework\View\Element\Template\Context $context
    ) {
		$this->_imageprocessor = $imageprocessor;
		$this->_storeManager = $context->getStoreManager();
    }
	
    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
		$thumbDirtmp = str_replace( $this->_imageprocessor->getSliderMediaPath(), 
			$this->_imageprocessor->getSliderMediaPath('thumb'), 
			$row->getSliderImagePath()
		);
		
		
        return '<span class="grid-row-title">
		<img src="'.$this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA ).$thumbDirtmp.'" >
		</span>';
    }
}
