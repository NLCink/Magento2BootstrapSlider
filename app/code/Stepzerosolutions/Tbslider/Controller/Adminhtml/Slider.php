<?php
/**
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml;

use Stepzerosolutions\Tbslider\Api\Data\SliderInterfaceFactory;
use Stepzerosolutions\Tbslider\Api\SliderRepositoryInterface;

/**
 * TBSlider manage slider controller
 *
 * @author      D.N.N Udugala <info@stepzero.solutions>
 */
abstract class Slider extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var sliderRepository
     */
    protected $sliderRepository;

    /**
     * @var sliderDataFactory
     */
    protected $sliderDataFactory;

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
        SliderRepositoryInterface $sliderRepository,
        SliderInterfaceFactory $sliderDataFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->sliderRepository = $sliderRepository;
        $this->sliderDataFactory = $sliderDataFactory;
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
        return $this->_authorization->isAllowed('Stepzerosolutions_Tbslider::Slider');
    }
}