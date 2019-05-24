<?php
namespace Smaex\Sitemap\Model\ItemProvider;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @inheritDoc
 */
class HomePageConfigReader implements HomePageConfigReaderInterface
{
    const XML_PATH_CHANGE_FREQUENCY = 'sitemap/home_page/changefreq';
    const XML_PATH_PRIORITY         = 'sitemap/home_page/priority';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     *
     * @codeCoverageIgnore
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getPriority($storeId): string
    {
        $storeId = (int) $storeId;

        return $this->getConfigValue(self::XML_PATH_PRIORITY, $storeId);
    }

    /**
     * @inheritDoc
     *
     * @codeCoverageIgnore
     */
    public function getChangeFrequency($storeId): string
    {
        $storeId = (int) $storeId;

        return $this->getConfigValue(self::XML_PATH_CHANGE_FREQUENCY, $storeId);
    }

    /**
     * @param int $storeId
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getHomePageIdentifier(int $storeId): string
    {
        return $this->getConfigValue(Page::XML_PATH_HOME_PAGE, $storeId);
    }

    /**
     * @param string $configPath
     * @param int    $storeId
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    private function getConfigValue(string $configPath, int $storeId): string
    {
        $configValue = $this->scopeConfig->getValue(
            $configPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return (string) $configValue;
    }
}
