<?php

declare(strict_types=1);

namespace Magenable\Popup\Model\Config\Source;

class VisibilityType implements \Magento\Framework\Data\OptionSourceInterface
{
    public const VISIBILITY_TYPE_EXCLUDE = 'exclude';
    public const VISIBILITY_TYPE_INCLUDE = 'include';

    public function toOptionArray(): ?array
    {
        return [
            [
                'value' => self::VISIBILITY_TYPE_EXCLUDE,
                'label' => 'Exclude popup from specified pages'
            ],
            [
                'value' => self::VISIBILITY_TYPE_INCLUDE,
                'label' => 'Show popup only on specified pages'
            ]
        ];
    }
}
