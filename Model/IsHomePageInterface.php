<?php
namespace Smaex\Sitemap\Model;

/**
 * Checks if the given page ID belongs to
 * the home page for the current store.
 *
 * @api
 */
interface IsHomePageInterface
{
    /**
     * @param int $pageId
     *
     * @return bool
     */
    public function execute(int $pageId): bool;
}
