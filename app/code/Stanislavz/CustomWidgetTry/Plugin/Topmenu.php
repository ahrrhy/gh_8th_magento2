<?php

namespace Stanislavz\CustomWidgetTry\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    /**
     * @var NodeFactory
     */
    protected $nodeFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * Topmenu constructor.
     * @param NodeFactory $nodeFactory
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_urlBuilder = $urlBuilder;
    }

    /**
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject
    ) {
        $page = $this->getCmspage('geekhub-cms');
        if ($page === null) {
            return;
        }

        $node = $this->nodeFactory->create(
            [
                'data' => [
                    'name' => __('Special offers'),
                    'id' => 'geekhub-cms',
                    'url' => $this->_urlBuilder->getUrl(null, ['_direct' =>'geekhub-cms']),
                    'has_active' => false,
                    'is_active' => false
                ],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    /**
     * @param $identifier
     * @return \Magento\Cms\Model\Page|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getCmspage($identifier)
    {

        $page = $this->_pageFactory->create();
        $pageId = $page->checkIdentifier($identifier, $this->_storeManager->getStore()->getId());

        if (!$pageId) {
            return null;
        }
        $page->setStoreId($this->_storeManager->getStore()->getId());
        if (!$page->load($pageId)) {
            return null;
        }

        if (!$page->getId()) {
            return null;
        }

        return $page;
    }
}
