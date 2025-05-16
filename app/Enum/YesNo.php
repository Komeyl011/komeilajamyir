<?php

namespace App\Enum;

enum YesNo: int
{
    case YES = 1;
    case NO = 0;

    /**
     * Return the corresponding translated label for the case to be shown to the user
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::YES => __('enum.yes'),
            self::NO => __('enum.no'),
        };
    }

    /**
     * Return the color for the case to be shown to the user
     *
     * @return string
     */
    public function color(): string
    {
        return match ($this) {
            self::YES => 'success',
            self::NO => 'danger',
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
            self::YES->value => 'success',
            self::NO->value => 'danger',
        ];
    }
}
