<?php
namespace Smaex\Sitemap\Test\Unit\Plugin;

use Magento\Cms\Helper\Page;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Result;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Smaex\Sitemap\Model\IsHomePageInterface;
use Smaex\Sitemap\Plugin\Canonical;

/**
 * @covers \Smaex\Sitemap\Plugin\Canonical
 */
class CanonicalTest extends TestCase
{
    const BASE_URL = 'https://example.com/';

    /**
     * @var MockObject|Canonical
     */
    private $instance;
    /**
     * @var MockObject|Action
     */
    private $mockAction;
    /**
     * @var MockObject|IsHomePageInterface
     */
    private $mockIsHomePage;
    /**
     * @var MockObject|Page
     */
    private $mockPage;
    /**
     * @var MockObject|Config
     */
    private $mockPageConfig;
    /**
     * @var MockObject|RequestInterface
     */
    private $mockRequest;
    /**
     * @var MockObject|Result\Page
     */
    private $mockResultPage;
    /**
     * @var MockObject|UrlInterface
     */
    private $mockUrl;

    /**
     * @param string $actionName
     * @param bool   $isHomepage
     * @param bool   $hasResultPage
     * @param bool   $addsCanonical
     *
     * @return void
     *
     * @dataProvider providesTestAfterPrepareResultPage
     */
    public function testAfterPrepareResultPage(string $actionName, bool $isHomepage, bool $hasResultPage, bool $addsCanonical): void
    {
        if ($hasResultPage) {
            $resultPage = $this->mockResultPage;
        } else {
            $resultPage = false;
        }
        if ($addsCanonical) {
            $addsRemotePageAsset = $this->atLeastOnce();
        } else {
            $addsRemotePageAsset = $this->never();
        }
        $this->mockRequest->method('getActionName')
            ->willReturn(
                $actionName
            );
        $this->mockIsHomePage->method('execute')
            ->willReturn(
                $isHomepage
            );
        $this->mockPageConfig
            ->expects(
                $addsRemotePageAsset
            )->method(
                'addRemotePageAsset'
            )->with(
                self::BASE_URL,
                'canonical',
                [
                    'attributes' => [ 'rel' => 'canonical' ]
                ]
            );
        $this->assertSame(
            $resultPage,
            $this->instance->afterPrepareResultPage(
                $this->mockPage,
                $resultPage,
                $this->mockAction
            )
        );
    }

    /**
     * @return array
     */
    public function providesTestAfterPrepareResultPage(): array
    {
        return [
            [ 'index', true,  true,  true  ],
            [ 'index', false, true,  true  ],
            [ 'index', true,  false, false ],
            [ 'other', true,  true,  true  ],
            [ 'other', false, true,  false ],
            [ 'other', true,  false, false ]
        ];
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    protected function setUp()
    {
        parent::setUp();

        $this->mockAction     = $this->createMock(Action::class);
        $this->mockIsHomePage = $this->createMock(IsHomePageInterface::class);
        $this->mockPage       = $this->createMock(Page::class);
        $this->mockPageConfig = $this->createMock(Config::class);
        $this->mockRequest    = $this->createMock(RequestInterface::class);
        $this->mockResultPage = $this->createMock(Result\Page::class);
        $this->mockUrl        = $this->createMock(UrlInterface::class);

        $this->mockAction->method('getRequest')
            ->willReturn(
                $this->mockRequest
            );
        $this->mockResultPage->method('getConfig')
            ->willReturn(
                $this->mockPageConfig
            );
        $this->mockUrl->method('getBaseUrl')
            ->willReturn(
                self::BASE_URL
            );

        $this->instance = new Canonical(
            $this->mockIsHomePage,
            $this->mockUrl
        );
    }
}
