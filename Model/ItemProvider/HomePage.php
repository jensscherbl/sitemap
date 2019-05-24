<?php
namespace Smaex\Sitemap\Model\ItemProvider;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\GetPageByIdentifierInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;
use Magento\Sitemap\Model\SitemapItemFactory;
use Magento\Sitemap\Model\SitemapItemInterface;

/**
 * @inheritDoc
 */
class HomePage implements ItemProviderInterface
{
    /**
     * @var HomePageConfigReaderInterface
     */
    private $configReader;
    /**
     * @var GetPageByIdentifierInterface
     */
    private $getPageByIdentifier;
    /**
     * @var SitemapItemFactory
     */
    private $itemFactory;

    /**
     * @param HomePageConfigReaderInterface $configReader
     * @param GetPageByIdentifierInterface  $getPageByIdentifier
     * @param SitemapItemFactory            $itemFactory
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        HomePageConfigReaderInterface $configReader,
        GetPageByIdentifierInterface  $getPageByIdentifier,
        SitemapItemFactory            $itemFactory
    ) {
        $this->configReader        = $configReader;
        $this->getPageByIdentifier = $getPageByIdentifier;
        $this->itemFactory         = $itemFactory;
    }

    /**
     * @inheritDoc
     *
     * @throws NoSuchEntityException
     *
     * @codeCoverageIgnore
     */
    public function getItems($storeId): array
    {
        return [ $this->getItem($storeId) ];
    }

    /**
     * @param int $storeId
     *
     * @return SitemapItemInterface
     *
     * @throws NoSuchEntityException
     *
     * @codeCoverageIgnore
     */
    private function getItem(int $storeId): SitemapItemInterface
    {
        $updatedAt       = $this->getUpdatedAt($storeId);
        $priority        = $this->getPriority($storeId);
        $changeFrequency = $this->getChangeFrequency($storeId);

        return $this->itemFactory->create(
            [
                'url'             => '',
                'updatedAt'       => $updatedAt,
                'priority'        => $priority,
                'changeFrequency' => $changeFrequency
            ]
        );
    }

    /**
     * @param int $storeId
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    private function getChangeFrequency(int $storeId): string
    {
        return $this->configReader->getChangeFrequency($storeId);
    }

    /**
     * @param int $storeId
     *
     * @return PageInterface
     *
     * @throws NoSuchEntityException
     *
     * @codeCoverageIgnore
     */
    private function getHomePage(int $storeId): PageInterface
    {
        $identifier = $this->getHomePageIdentifier($storeId);

        return $this->getPageByIdentifier->execute($identifier, $storeId);
    }

    /**
     * @param int $storeId
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    private function getHomePageIdentifier(int $storeId): string
    {
        return $this->configReader->getHomePageIdentifier($storeId);
    }

    /**
     * @param int $storeId
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    private function getPriority(int $storeId): string
    {
        return $this->configReader->getPriority($storeId);
    }

    /**
     * @param int $storeId
     *
     * @return string
     *
     * @throws NoSuchEntityException
     *
     * @codeCoverageIgnore
     */
    private function getUpdatedAt(int $storeId): string
    {
        $homePage = $this->getHomePage($storeId);

        return (string) $homePage->getUpdateTime();
    }
}
