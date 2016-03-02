<?php
/**
 *
 * Copyright © 2015 Stepzero.Solutions. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider;

use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends \Stepzerosolutions\Tbslider\Controller\Adminhtml\Slider
{
    /**
     * Delete customer group.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->sliderRepository->deleteById($id);
                $this->messageManager->addSuccess(__('You deleted the Slider.'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('The Slider no longer exists.'));
                return $resultRedirect->setPath('tbslider/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('tbslider/slider/edit', ['id' => $id]);
            }
        }
        return $resultRedirect->setPath('tbslider/slider');
    }
}
