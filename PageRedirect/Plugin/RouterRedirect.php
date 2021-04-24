<?php

namespace Magenest\PageRedirect\Plugin;

use Magento\Framework\App\Router\DefaultRouter;
use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Search\Model\ResourceModel\Query\CollectionFactory as SearchCollection;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\ActionFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;

/**
 * Class RouterRedirect
 * @package Magenest\PageRedirect\Plugin
 */
class RouterRedirect
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * @var SearchCollection
     */
    protected $searchCollection;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ActionFactory
     */
    protected $actionFactory;

    /**
     * @var UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;

    /**
     * RouterRedirect constructor.
     * @param UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     * @param ManagerInterface $messageManager
     * @param SearchCollection $searchCollection
     * @param ProductCollection $productCollection
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory,
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $messageManager,
        SearchCollection $searchCollection,
        ProductCollection $productCollection,
        StoreManagerInterface $storeManager,
        CollectionFactory $collectionFactory
    ) {
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->messageManager = $messageManager;
        $this->searchCollection = $searchCollection;
        $this->productCollection = $productCollection;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param DefaultRouter $subject
     * @param callable $proceed
     * @param RequestInterface $request
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function aroundMatch(DefaultRouter $subject, callable $proceed, RequestInterface $request)
    {
        $identifier = explode('/', trim($request->getPathInfo(), '/'));
        foreach ($identifier as $singlePath) {
            $category = $this->findCategory($singlePath);
            if ($category->getId()) {
                $request->setModuleName('catalog')->setControllerName('category')->setActionName('view')
                    ->setParams(['id' => $category->getId()]);
                $requestPath = $this->getRequestPath('category', $category->getId());
                $this->response->setRedirect($requestPath);
                $this->messageManager->addNoticeMessage(__('The path %1 does not exists. Are you looking for %2', $request->getPathInfo(), $category->getName()));
                return $this->actionFactory->create(\Magento\Framework\App\Action\Redirect::class);
            }
            $searchTerm = $this->findSearchTerm(urldecode($singlePath));
            if ($searchTerm->getId()) {
                $request->setModuleName('catalogsearch')->setControllerName('result')->setActionName('index')
                    ->setParams(['q' => urlencode($searchTerm->getQueryText())]);
                $this->response->setRedirect('catalogsearch/result/?q='.urlencode($searchTerm->getQueryText()));
                return $this->actionFactory->create(\Magento\Framework\App\Action\Redirect::class);
            }
            if (strlen($singlePath) > 3) {
                $product = $this->findProduct($singlePath);
                if ($product->getId()) {
                    $request->setModuleName('catalog')->setControllerName('product')->setActionName('view')
                        ->setParams(['id' => $product->getId()]);
                    $requestPath = $this->getRequestPath('product', $product->getId());
                    $this->response->setRedirect($requestPath);
                    return $this->actionFactory->create(\Magento\Framework\App\Action\Redirect::class);
                }
            }
        }
        return $proceed($request);
    }

    /**
     * Search category by key
     * @param $key
     * @return \Magento\Framework\DataObject
     */
    private function findCategory($key)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('name', ['like' => '%' . $key . '%']);
        return $collection->getFirstItem();
    }

    /**
     * Search product by name
     * @param $key
     * @return \Magento\Framework\DataObject
     */
    private function findProduct($key)
    {
        $collection = $this->productCollection->create();
        $collection->addFieldToFilter('name', ['like' => '%' . $key . '%']);
        return $collection->getFirstItem();
    }

    /**
     * Search term
     * @param $key
     * @return \Magento\Framework\DataObject
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function findSearchTerm($key)
    {
        $currentStoreId = $this->storeManager->getStore()->getId();
        $collection = $this->searchCollection->create();
        $collection->addFieldToFilter('query_text', ['like' => '%' . $key . '%']);
        $collection->addFieldToFilter('is_active', 1);
        $collection->addFieldToFilter('store_id', $currentStoreId);
        return $collection->getFirstItem();
    }

    /**
     * @param $type
     * @param $id
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getRequestPath($type, $id)
    {
        $currentStoreId = $this->storeManager->getStore()->getId();
        $urlRewrite = $this->urlRewriteCollectionFactory->create()
            ->addFieldToFilter('entity_type', $type)
            ->addFieldToFilter('entity_id', $id)
            ->addFieldToFilter('store_id', $currentStoreId)
            ->getFirstItem();
        if ($urlRewrite->getUrlRewriteId()) {
            return $urlRewrite->getRequestPath();
        } else {
            $requestPath = 'catalog/' . $type . '/view/id/' . $id;
        }
        return $requestPath;
    }
}
