<?php
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems;
 
class Index extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slideritems
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
        $resultPage->addBreadcrumb(__('Slider Items'), __('Slider items'));
        $resultPage->addBreadcrumb(__('Manage Slider Items'), __('Manage Slider Items'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Slider Items'));
        return $resultPage;
    }
}