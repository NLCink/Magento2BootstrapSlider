<?php
/**
 *
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider;

use Stepzerosolutions\Tbslider\Controller\RegistryConstants;

class NewAction extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider
{
    /**
     * Initialize current group and set it in the registry.
     *
     * @return int
     */
    protected function _initSlider()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $this->_coreRegistry->register(RegistryConstants::CURRENT_SLIDER_ID, $sliderId);
        return $sliderId;
    }

    /**
     * Edit or create slider.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $sliderId = $this->_initSlider();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Stepzerosolutions_Tbslider::szslidermenu');
        $resultPage->getConfig()->getTitle()->prepend(__('Slider'));
        $resultPage->addBreadcrumb(__('Slider'), __('Slider'));
        $resultPage->addBreadcrumb(__('Sliders'), __('Sliders'), $this->getUrl('tbslider/slider'));

        if ($sliderId === null) {
            $resultPage->addBreadcrumb(__('New Slider'), __('New Slider'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Slider'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Slider'), __('Edit Slider'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->sliderRepository->getById($sliderId)->getCode()
            );
        }

        $resultPage->getLayout()->addBlock('Stepzerosolutions\Tbslider\Block\Adminhtml\Slider\Edit', 'slider', 'content')
            ->setEditMode((bool)$sliderId);

        return $resultPage;
    }
}
