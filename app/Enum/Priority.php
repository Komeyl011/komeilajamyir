<?php

namespace App\Enum;

enum Priority: string
{
    case HIGH = 'HIGH';
    case NORMAL = 'NORMAL';
    case LOW = 'LOW';

    /**
     * Return the corresponding translated label for the case to be shown to the user
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::HIGH => __('enum.priority.high'),
            self::NORMAL => __('enum.priority.normal'),
            self::LOW => __('enum.priority.low'),
        };
    }

    public static function labels(): array
    {
        return [
            self::HIGH->value => __('enum.priority.high'),
            self::NORMAL->value => __('enum.priority.normal'),
            self::LOW->value => __('enum.priority.low'),
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
            self::HIGH => 'primary',
            self::NORMAL => 'cyan',
            self::LOW => 'danger',
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
            self::HIGH->value => 'primary',
            self::NORMAL->value => 'cyan',
            self::LOW->value => 'danger',
        ];
    }
}
