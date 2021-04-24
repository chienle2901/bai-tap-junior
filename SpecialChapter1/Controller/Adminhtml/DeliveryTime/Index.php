<?php

namespace Magenest\SpecialChapter1\Controller\Adminhtml\DeliveryTime;

use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index
 * @package Magenest\SpecialChapter1\Controller\DeliveryTime
 */
class Index extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Magenest_SpecialChapter1::manager';

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $this->_setActiveMenu('Magenest_SpecialChapter1::manager')
            ->_addBreadcrumb(__('Delivery Time Manager'), __('Delivery Time Manager'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Delivery Time Manager'));
        return $resultPage;
    }
}
