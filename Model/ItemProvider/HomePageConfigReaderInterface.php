<?php
namespace Smaex\Sitemap\Model\ItemProvider;

use Magento\Sitemap\Model\ItemProvider\ConfigReaderInterface;

/**
 * @inheritDoc
 */
interface HomePageConfigReaderInterface extends ConfigReaderInterface
{
    /**
     * @param int $storeId
     *
     * @return string
     */
    public function getHomePageIdentifier(int $storeId): string;
}
