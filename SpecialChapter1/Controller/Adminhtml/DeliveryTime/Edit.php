<?php

namespace Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Edit
 * @package Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime
 */
class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magenest_SpecialChapter1::edit';

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $id = $this->getRequest()->getParam('id', null);
        $title = __('Add New Delivery Time');
        if ($id) {
            $title = __('Edit Delivery Time');
        }
        $this->_setActiveMenu('Magenest_SpecialChapter1::edit')
            ->_addBreadcrumb(__('Add New Delivery Time'), $title);
        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
