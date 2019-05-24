<?php
namespace Smaex\Sitemap\Plugin;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Action\Action;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result;
use Smaex\Sitemap\Model\IsHomePageInterface;

/**
 * Adds a canonical tag to the home page.
 */
class Canonical
{
    /**
     * @var IsHomePageInterface
     */
    private $isHomePage;
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @param IsHomePageInterface $isHomePage
     * @param UrlInterface        $url
     *
     * @codeCoverageIgnore
     */
    public function __construct(IsHomePageInterface $isHomePage, UrlInterface $url)
    {
        $this->isHomePage = $isHomePage;
        $this->url        = $url;
    }

    /**
     * @param Page   $page
     * @param mixed  $result
     * @param Action $action
     * @param mixed  $pageId
     *
     * @return mixed
     */
    public function afterPrepareResultPage(Page $page, $result, Action $action, $pageId = null)
    {
        $pageId = (int) $pageId;

        if ($this->isIndex($action) || $this->isHomePage($pageId)) {
            $this->addCanonicalTag(
                $result,
                $this->getBaseUrl()
            );
        }
        return $result;
    }

    /**
     * @param mixed  $result
     * @param string $url
     *
     * @return void
     */
    private function addCanonicalTag($result, string $url): void
    {
        if ($result instanceof Result\Page) {
            $result->getConfig()->addRemotePageAsset(
                $url,
                'canonical',
                [
                    'attributes' => [ 'rel' => 'canonical' ]
                ]
            );
        }
    }

    /**
     * @return string
     */
    private function getBaseUrl(): string
    {
        return (string) $this->url->getBaseUrl();
    }

    /**
     * @param int $pageId
     *
     * @return bool
     */
    private function isHomePage(int $pageId): bool
    {
        return $this->isHomePage->execute($pageId);
    }

    /**
     * @param Action $action
     *
     * @return bool
     */
    private function isIndex(Action $action): bool
    {
        $actionName = $action->getRequest()->getActionName();

        return $actionName === 'index';
    }
}
