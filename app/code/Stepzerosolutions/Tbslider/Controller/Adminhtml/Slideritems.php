<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml;

use Stepzerosolutions\Tbslider\Api\Data\SlideritemsInterfaceFactory;
use Stepzerosolutions\Tbslider\Api\SlideritemsRepositoryInterface;

/**
 * TBSlider manage slide controller
 *
 * @author      D.N.N Udugala <info@stepzero.solutions>
 */
abstract class Slideritems  extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var slideritemsRepository
     */
    protected $slideritemsRepository;

    /**
     * @var slideritemsDataFactory
     */
    protected $slideritemsDataFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * Init actions
     *
     * @return $this
     */
	 
	
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        SlideritemsRepositoryInterface $slideritemsRepository,
        SlideritemsInterfaceFactory $slideritemsDataFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->slideritemsRepository = $slideritemsRepository;
        $this->slideritemsDataFactory = $slideritemsDataFactory;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
    }
	
	
	
    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Stepzerosolutions_Tbslider::slider_items');
    }
}