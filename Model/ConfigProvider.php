<?php

declare(strict_types=1);

namespace Magenable\Popup\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Newsletter\Model\Config as NewsletterConfig;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    public const CONFIG_POPUP_TITLE = 'magenable_popup/general/popup_title';
    public const CONFIG_CMS_BLOCK = 'magenable_popup/general/cms_block';
    public const CONFIG_BUTTON_TEXT = 'magenable_popup/general/button_text';
    public const CONFIG_POPUP_DELAY = 'magenable_popup/general/popup_delay';
    public const CONFIG_VISIBILITY_TYPE = 'magenable_popup/visibility/type';
    public const CONFIG_VISIBILITY_PAGES = 'magenable_popup/visibility/pages';
    public const CONFIG_NEWSLETTER_ENABLED = 'magenable_popup/newsletter/enabled';
    public const CONFIG_POPUP_MAX_WIDTH = 'magenable_popup/design/popup_max_width';
    public const CONFIG_BUTTON_TEXT_COLOR = 'magenable_popup/design/button_text_color';
    public const CONFIG_BUTTON_BACKGROUND = 'magenable_popup/design/button_background';

    private ScopeConfigInterface $scopeConfig;
    private NewsletterConfig $newsletterConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        NewsletterConfig $newsletterConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->newsletterConfig = $newsletterConfig;
    }

    public function getPopupTitle(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_POPUP_TITLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getCmsBlockId(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_CMS_BLOCK,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getPopupDelay(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::CONFIG_POPUP_DELAY,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getVisibilityType(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_VISIBILITY_TYPE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getVisibilityPages(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_VISIBILITY_PAGES,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function isNewsletterEnabled(): bool
    {
        if (!$this->newsletterConfig->isActive(ScopeInterface::SCOPE_STORE)) {
            return false;
        }

        return (bool)$this->scopeConfig->getValue(
            self::CONFIG_NEWSLETTER_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getButtonText(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_BUTTON_TEXT,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getPopupMaxWidth(): int
    {
        return (int)$this->scopeConfig->getValue(
            self::CONFIG_POPUP_MAX_WIDTH,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getButtonTextColor(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_BUTTON_TEXT_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getButtonBackground(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_BUTTON_BACKGROUND,
            ScopeInterface::SCOPE_STORE
        );
    }
}
