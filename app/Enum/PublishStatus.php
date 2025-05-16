<?php

namespace App\Enum;

enum PublishStatus: string
{
    case PUBLISHED = 'PUBLISHED';
    case PENDING = 'PENDING';
    case DRAFT = 'DRAFT';

    /**
     * Return the corresponding translated label for the case to be shown to the user
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::PUBLISHED => __('enum.publish_status.published'),
            self::PENDING => __('enum.publish_status.pending'),
            self::DRAFT => __('enum.publish_status.draft'),
        };
    }

    /**
     * Return the translated labels array
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::PUBLISHED->value => __('enum.publish_status.published'),
            self::PENDING->value => __('enum.publish_status.pending'),
            self::DRAFT->value => __('enum.publish_status.draft'),
        ];
    }

    /**
     * Return the color for the case to be shown to the user
     *
     * @return string
     */
    public function color(): string
    {
        return match ($this) {
            self::PUBLISHED => 'success',
            self::PENDING => 'cyan',
            self::DRAFT => 'primary',
        };
    }

    /**
     * Return the colors for the cases to be shown to the user
     *
     * @return array
     */
    public static function colors(): array
    {
        return [
            self::PUBLISHED->value => 'success',
            self::PENDING->value => 'cyan',
            self::DRAFT->value => 'primary',
        ];
    }
}
