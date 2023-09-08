<?php

declare(strict_types=1);

namespace Magenable\Popup\Model;

use Magento\Framework\App\Request\Http;
use Magenable\Popup\Model\Config\Source\VisibilityType;

class VisibilityChecker
{
    private ConfigProvider $configProvider;
    private Http $request;

    public function __construct(
        ConfigProvider $configProvider,
        Http $request
    ) {
        $this->configProvider = $configProvider;
        $this->request = $request;
    }

    public function isVisible(): bool
    {
        $visibilityType = $this->configProvider->getVisibilityType();
        $visibilityPages = $this->configProvider->getVisibilityPages();
        $visibilityPages = explode("\n", $visibilityPages);
        array_walk($visibilityPages, function (&$page) {
            $page = $this->trim($page);
        });

        $uriPath = $this->trim($this->request->getUri()->getPath());

        if ($visibilityType === VisibilityType::VISIBILITY_TYPE_EXCLUDE) {
            if (in_array($uriPath, $visibilityPages, true)) {
                return false;
            }
        }
        if ($visibilityType === VisibilityType::VISIBILITY_TYPE_INCLUDE) {
            if (!in_array($uriPath, $visibilityPages, true)) {
                return false;
            }
        }

        return true;
    }

    private function trim(string $string): string
    {
        return trim($string, " \n\r\t\v\x00/");
    }
}
