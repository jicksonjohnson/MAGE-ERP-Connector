<?php

declare(strict_types=1);

namespace HelloMage\ErpConnector\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected StoreManagerInterface $_storeManager;

	protected \Magento\Framework\Url $_url;

	protected \Magento\Cms\Model\PageFactory $_pageFactory;

	protected \Magento\Cms\Model\Template\FilterProvider $_filterProvider;

    /**
     * Helper Data constructor.
     *
     * @param Context $context
     * @param \Magento\Framework\Url $url
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
		\Magento\Framework\Url $url,
		\Magento\Cms\Model\PageFactory $pageFactory,
		\Magento\Cms\Model\Template\FilterProvider $filterProvider,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
		$this->_url = $url;
		$this->_pageFactory = $pageFactory;
		$this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    /**
     * Get Store configuration
     *
     * @param $path
     * @param null $store
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreConfig($path, $store = null)
    {
        if ($store == null || $store == '') {
            $store = $this->_storeManager->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);

        return $config = $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $store);
    }

    /**
     * Get URL
     *
     * @param $identifier
     * @return string
     */
	public function getUrlBuilder($identifier){
		return $this->_url->getUrl($identifier);
	}

    /**
     * Get CMS Page Content
     *
     * @param $identifier
     * @return string
     * @throws \Exception
     */
	function getPageContent($identifier){
		$page = $this->_pageFactory->create()->load($identifier);
		return $this->_filterProvider->getPageFilter()->filter($page->getContent());
	}
}
