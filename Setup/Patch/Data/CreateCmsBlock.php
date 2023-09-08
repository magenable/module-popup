<?php

declare(strict_types=1);

namespace Magenable\Popup\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magenable\Popup\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class CreateCmsBlock implements DataPatchInterface
{
    private BlockRepositoryInterface $blockRepository;
    private BlockInterfaceFactory $blockInterfaceFactory;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     */
    public function apply()
    {
        try {
            $this->blockRepository->getById(Data::DEFAULT_CMS_BLOCK_ID);
            return;
        } catch (NoSuchEntityException $e) {}
        $newCmsBlock = $this->blockInterfaceFactory->create();
        $newCmsBlock->setTitle('Magenable Popup Content');
        $newCmsBlock->setIdentifier(Data::DEFAULT_CMS_BLOCK_ID);
        $newCmsBlock->setContent('<div style="text-align: center;">Enter your <b>email</b> in the field below</div>');
        $this->blockRepository->save($newCmsBlock);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}
