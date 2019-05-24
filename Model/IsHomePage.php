<?php
namespace Smaex\Sitemap\Model;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Smaex\Sitemap\Model\ItemProvider\HomePageConfigReaderInterface;

/**
 * @inheritDoc
 */
class IsHomePage implements IsHomePageInterface
{
    /**
     * @var HomePageConfigReaderInterface
     */
    private $configReader;
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param HomePageConfigReaderInterface $configReader
     * @param PageRepositoryInterface       $pageRepository
     * @param StoreManagerInterface         $storeManager
     *
     * @codeCoverageIgnore
     */
    public function __construct(
        HomePageConfigReaderInterface $configReader,
        PageRepositoryInterface       $pageRepository,
        StoreManagerInterface         $storeManager
    ) {
        $this->configReader   = $configReader;
        $this->pageRepository = $pageRepository;
        $this->storeManager   = $storeManager;
    }

    /**
     * @inheritDoc
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(int $pageId): bool
    {
        $pageIdentifier     = $this->getPageIdentifier($pageId);
        $homePageIdentifier = $this->getHomePageIdentifier();

        return $pageIdentifier === $homePageIdentifier;
    }

    /**
     * @return string
     *
     * @throws NoSuchEntityException
     */
    private function getHomePageIdentifier(): string
    {
        $storeId = $this->getStoreId();

        return $this->configReader->getHomePageIdentifier($storeId);
    }

    /**
     * @param int $pageId
     *
     * @return string
     *
     * @throws LocalizedException
     */
    private function getPageIdentifier(int $pageId): string
    {
        $page = $this->pageRepository->getById($pageId);

        return (string) $page->getIdentifier();
    }

    /**
     * @return int
     *
     * @throws NoSuchEntityException
     */
    private function getStoreId(): int
    {
        $store = $this->storeManager->getStore();

        return (int) $store->getId();
    }
}
