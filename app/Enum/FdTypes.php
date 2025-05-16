<?php

namespace App\Enum;

enum FdTypes: string
{
    case GAME = 'GAME';
    case DISCUSSION = 'DISCUSSION';
    case MIXED = 'MIXED';

    /**
     * Return the corresponding translated label for the case to be shown to the user
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::GAME => __('enum.fd-types.game'),
            self::DISCUSSION => __('enum.fd-types.discussion'),
            self::MIXED => __('enum.fd-types.mixed'),
        };
    }

    /**
     * Return the labels for the cases to be shown to the user
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::GAME->value => __('enum.fd-types.game'),
            self::DISCUSSION->value => __('enum.fd-types.discussion'),
            self::MIXED->value => __('enum.fd-types.mixed'),
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
            self::GAME => 'cyan',
            self::DISCUSSION => 'success',
            self::MIXED => 'warning',
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
            self::GAME->value => 'cyan',
            self::DISCUSSION->value => 'success',
            self::MIXED->value => 'warning',
        ];
    }
}
