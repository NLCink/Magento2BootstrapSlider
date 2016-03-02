<?php
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider;
 
class Index extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider
{
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Stepzerosolutions_Tbslider::slider');
        $resultPage->addBreadcrumb(__('Slider'), __('Slider'));
        $resultPage->addBreadcrumb(__('Manage Sliders'), __('Manage Sliders'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Sliders'));
        return $resultPage;
    }
}