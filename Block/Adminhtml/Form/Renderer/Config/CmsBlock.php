<?php

declare(strict_types=1);

namespace Magenable\Popup\Block\Adminhtml\Form\Renderer\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Framework\UrlInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;

class CmsBlock extends Field
{
    private ?SecureHtmlRenderer $secureRenderer;
    private ?UrlInterface $url;
    private ?BlockRepositoryInterface $cmsBlockRepository;

    public function __construct(
        Context $context,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null,
        ?UrlInterface $url = null,
        ?BlockRepositoryInterface $cmsBlockRepository = null
    ) {
        parent::__construct($context, $data, $secureRenderer);

        $this->secureRenderer = ObjectManager::getInstance()->get(SecureHtmlRenderer::class);
        $this->url = ObjectManager::getInstance()->get(UrlInterface::class);
        $this->cmsBlockRepository = ObjectManager::getInstance()->get(BlockRepositoryInterface::class);
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws LocalizedException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html = parent::_getElementHtml($element);

        $cmsBlockslinks = [];
        foreach ($element->getData('values') as $item) {
            try {
                $cmsBlockId = (int)$this->cmsBlockRepository->getById($item['value'])->getId();
            } catch (NoSuchEntityException $e) {
                continue;
            }
            $cmsBlockslinks[$item['value']] = $this->url->getUrl('cms/block/edit', ['block_id' => $cmsBlockId]);
        }
        $cmsBlockslinks = json_encode($cmsBlockslinks);

        $html .= '<a href="#" target="_blank" id="magenable-popup-open-selected-cms-block">' .
            __('Open selected CMS Block in new tab') . '</a>';

        $html .= $this->secureRenderer->renderStyleAsTag(
            'display:inline-block;margin-top:5px',
            '#magenable-popup-open-selected-cms-block'
        );

        $script = <<<script
            const magenablePopupCmsBlocksLinks = JSON.parse('{$cmsBlockslinks}');
            document.getElementById('magenable-popup-open-selected-cms-block').addEventListener('click', function (e) {
                const selectInput = document.getElementById('{$element->getId()}');
                e.currentTarget.href = magenablePopupCmsBlocksLinks[selectInput.value];
            });
        script;

        $html .= $this->secureRenderer->renderTag(
            'script',
            ['type' => 'text/javascript'],
            $script,
            false
        );

        return $html;
    }
}
