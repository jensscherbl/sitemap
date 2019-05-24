<?php
namespace Smaex\Sitemap\Test\Unit\Model;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Smaex\Sitemap\Model\IsHomePage;
use Smaex\Sitemap\Model\ItemProvider\HomePageConfigReaderInterface;

/**
 * @covers \Smaex\Sitemap\Model\IsHomePage
 */
class IsHomePageTest extends TestCase
{
    /**
     * @var MockObject|IsHomePage
     */
    private $instance;
    /**
     * @var MockObject|HomePageConfigReaderInterface
     */
    private $mockConfigReader;
    /**
     * @var MockObject|PageInterface
     */
    private $mockPage;
    /**
     * @var MockObject|PageRepositoryInterface
     */
    private $mockPageRepository;
    /**
     * @var MockObject|StoreInterface
     */
    private $mockStore;
    /**
     * @var MockObject|StoreManagerInterface
     */
    private $mockStoreManager;

    /**
     * @param string $pageIdentifier
     * @param string $homePageIdentifier
     * @param bool   $result
     *
     * @return void
     *
     * @throws LocalizedException
     * @throws NoSuchEntityException
     *
     * @dataProvider provideTestExecute
     */
    public function testExecute(string $pageIdentifier, string $homePageIdentifier, bool $result): void
    {
        $this->mockPage->method('getIdentifier')
            ->willReturn(
                $pageIdentifier
            );
        $this->mockConfigReader->method('getHomePageIdentifier')
            ->willReturn(
                $homePageIdentifier
            );
        $this->assertSame(
            $result,
            $this->instance->execute(42)
        );
    }

    /**
     * @return array
     */
    public function provideTestExecute(): array
    {
        return [
            [ 'home',  'home', true  ],
            [ 'other', 'home', false ]
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

        $this->mockConfigReader   = $this->createMock(HomePageConfigReaderInterface::class);
        $this->mockPage           = $this->createMock(PageInterface::class);
        $this->mockPageRepository = $this->createMock(PageRepositoryInterface::class);
        $this->mockStore          = $this->createMock(StoreInterface::class);
        $this->mockStoreManager   = $this->createMock(StoreManagerInterface::class);

        $this->mockPageRepository->method('getById')
            ->willReturn(
                $this->mockPage
            );
        $this->mockStoreManager->method('getStore')
            ->willReturn(
                $this->mockStore
            );

        $this->instance = new IsHomePage(
            $this->mockConfigReader,
            $this->mockPageRepository,
            $this->mockStoreManager
        );
    }
}
