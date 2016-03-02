<?php
/**
 *
 * Copyright © 2015 Stepzero.solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems;

use Stepzerosolutions\Tbslider\Controller\RegistryConstants;

class NewAction extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems
{
    /**
     * Initialize current group and set it in the registry.
     *
     * @return int
     */
    protected function _initSlideritems()
    {
        $slideritemId = $this->getRequest()->getParam('id');
        $this->_coreRegistry->register(RegistryConstants::CURRENT_SLIDERITEM_ID, $slideritemId);
        return $slideritemId;
    }

    /**
     * Edit or create slider.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $slideritemId = $this->_initSlideritems();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Stepzerosolutions_Tbslider::slideritems');
        $resultPage->getConfig()->getTitle()->prepend(__('Slider Item'));
        $resultPage->addBreadcrumb(__('Slider Item'), __('Slider Item'));
        $resultPage->addBreadcrumb(__('Slider Item'), __('Slider Item'), $this->getUrl('tbslider/slideritems'));

        if ($slideritemId === null) {
            $resultPage->addBreadcrumb(__('New Slider Item'), __('New Slider Item'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Slider Item'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Slider Item'), __('Edit Slider Item'));
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Slider Item'));
        }
        $resultPage->getLayout()->addBlock('Stepzerosolutions\Tbslider\Block\Adminhtml\Slideritems\Edit', 'slideritems', 'content')
            ->setEditMode((bool)$slideritemId);

        return $resultPage;
    }
}
