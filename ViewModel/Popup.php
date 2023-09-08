<?php

declare(strict_types=1);

namespace Magenable\Popup\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magenable\Popup\Model\ConfigProvider;
use Magenable\Popup\Model\VisibilityChecker;
use Magenable\Popup\Model\ContentProvider;
use Magento\Framework\Escaper;
use Magento\Newsletter\Block\Subscribe;
use Magento\Framework\Exception\LocalizedException;

class Popup implements ArgumentInterface
{
    private const POPUP_CSS_CLASS = 'magenable-popup';
    private const MODAL_CSS_CLASS = 'magenable-popup-modal';

    private ConfigProvider $configProvider;
    private VisibilityChecker $popupVisibilityChecker;
    private ContentProvider $contentProvider;
    private Escaper $escaper;
    private Subscribe $subscribe;

    public function __construct(
        ConfigProvider $configProvider,
        VisibilityChecker $popupVisibilityChecker,
        ContentProvider $contentProvider,
        Escaper $escaper,
        Subscribe $subscribe
    ) {
        $this->configProvider = $configProvider;
        $this->popupVisibilityChecker = $popupVisibilityChecker;
        $this->contentProvider = $contentProvider;
        $this->escaper = $escaper;
        $this->subscribe = $subscribe;
    }

    public function isVisible(): bool
    {
        return $this->popupVisibilityChecker->isVisible();
    }

    public function getEscaper(): Escaper
    {
        return $this->escaper;
    }

    public function getPopupTitle(): string
    {
        return $this->configProvider->getPopupTitle();
    }

    public function getModalCssClass(): string
    {
        return self::MODAL_CSS_CLASS;
    }

    public function getPopupCssClass(): string
    {
        return self::POPUP_CSS_CLASS;
    }

    /**
     * @throws LocalizedException
     */
    public function getPopupContentHtml(): string
    {
        return (string)$this->contentProvider->getContentHtml();
    }

    public function getPopupDelay(): int
    {
        return $this->configProvider->getPopupDelay();
    }

    public function isNewsletterEnabled(): int
    {
        return (int)$this->configProvider->isNewsletterEnabled();
    }

    public function getButtonText(): string
    {
        return $this->configProvider->getButtonText();
    }

    public function getPopupMaxWidth(): int
    {
        return $this->configProvider->getPopupMaxWidth();
    }

    public function getButtonTextCollor(): string
    {
        return $this->configProvider->getButtonTextColor();
    }

    public function getButtonBackground(): string
    {
        return $this->configProvider->getButtonBackground();
    }

    public function getFormActionUrl(): string
    {
        return (string)$this->subscribe->getFormActionUrl();
    }
}
