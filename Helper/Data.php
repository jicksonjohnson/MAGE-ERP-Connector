<?php
/**
 * HelloMage
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customise this module for your needs.
 * Please contact us jicksonkoottala@gmail.com
 *
 * @category   HelloMage
 * @package    HelloMage_ErpConnector
 * @copyright  Copyright (C) 2020 HELLOMAGE PVT LTD (https://www.hellomage.com/)
 * @license    https://www.hellomage.com/magento2-osl-3-0-license/
 */

declare(strict_types=1);

namespace HelloMage\ErpConnector\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Url;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\Template\FilterProvider;

/**
 * Class Data
 * @package HelloMage\ErpConnector\Helper\Data
 */
class Data extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $_storeManager;

    /**
     * @var Url
     */
    protected Url $_url;

    /**
     * @var PageFactory
     */
    protected PageFactory $_pageFactory;

    /**
     * @var FilterProvider
     */
    protected FilterProvider $_filterProvider;

    /**
     * Helper Data constructor.
     *
     * @param Context $context
     * @param Url $url
     * @param PageFactory $pageFactory
     * @param FilterProvider $filterProvider
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        Url $url,
        PageFactory $pageFactory,
        FilterProvider $filterProvider,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        $this->_url = $url;
        $this->_pageFactory = $pageFactory;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    /**
     * Get store configuration by path.
     *
     * @param string $path
     * @param null|int|string $store
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreConfig(string $path, $store = null)
    {
        if ($store === null || $store === '') {
            $store = $this->_storeManager->getStore()->getId();
        }
        $store = $this->_storeManager->getStore($store);

        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Get URL by identifier.
     *
     * @param string $identifier
     * @return string
     */
    public function getUrlBuilder(string $identifier): string
    {
        return $this->_url->getUrl($identifier);
    }

    /**
     * Get CMS page content by identifier.
     *
     * @param string $identifier
     * @return string
     * @throws \Exception
     */
    public function getPageContent(string $identifier): string
    {
        $page = $this->_pageFactory->create()->load($identifier);
        return $this->_filterProvider->getPageFilter()->filter($page->getContent());
    }
}