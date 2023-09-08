<?php

declare(strict_types=1);

namespace Magenable\Popup\Model;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\View\Layout;
use Magento\Cms\Block\BlockByIdentifier;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class ContentProvider
{
    private ConfigProvider $configProvider;
    private BlockRepositoryInterface $cmsBlockRepository;
    private Layout $layout;

    public function __construct(
        ConfigProvider $configProvider,
        BlockRepositoryInterface $cmsBlockRepository,
        Layout $layout
    ) {
        $this->configProvider = $configProvider;
        $this->cmsBlockRepository = $cmsBlockRepository;
        $this->layout = $layout;
    }

    /**
     * @throws LocalizedException
     */
    public function getContentHtml(): ?string
    {
        $cmsBlockId = $this->configProvider->getCmsBlockId();

        try {
            $cmsBlock = $this->cmsBlockRepository->getById($cmsBlockId);
        } catch (NoSuchEntityException) {
            return null;
        }

        if (!$cmsBlock->isActive()) {
            return null;
        }
        if (!$cmsBlock->getContent()) {
            return null;
        }

        return $this->layout->createBlock(BlockByIdentifier::class)
            ->setData('identifier', $cmsBlock->getIdentifier())
            ->toHtml();
    }
}
