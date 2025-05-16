<?php

namespace App\Filament\Resources;

use App\Enum\YesNo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;

abstract class BaseResource extends Resource
{
    private static array $fields;
    private static array $textTypes = ['text', 'textarea', 'date', 'text_json', 'textarea_json', 'richtext_json', 'richtext', 'number'];

    protected static function getFields()
    {
        $arr = include resource_path('lang/vendor/filament/'.app()->currentLocale().'/resources.php');
        self::$fields = $arr[self::getResourceName()]['table'];
    }

    protected static function getResourceName()
    {
        return Str::kebab(
            Str::before(class_basename(static::class), 'Resource'),
        );
    }

    protected static function autoCreateInputs(): array
    {
        self::getFields();
        $inputs = [];

        foreach (self::$fields as $key => $value) {
            if ($value['type'] == 'text') {
                $inputs[] = TextInput::make($key)
                    ->label($value['label'])
                    ->required($value['required']);
            } elseif ($value['type'] == 'number') {
                $inputs[] = TextInput::make($key)
                    ->label($value['label'])
                    ->numeric()
                    ->required($value['required']);
            } elseif ($value['type'] == 'textarea') {
                $inputs[] = Textarea::make($key)
                    ->label($value['label'])
                    ->required($value['required']);
            } elseif ($value['type'] == 'date') {
                $inputs[] = DatePicker::make($key)
                    ->label($value['label'])
                    ->required($value['required']);
            } elseif ($value['type'] == 'image') {
                $inputs[] = FileUpload::make($key)
                    ->label($value['label'])
                    ->required($value['required'])
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->rules(['mimes:jpg,jpeg,png'])
                    ->disk('liara')
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        $uuid = Str::uuid();
                        $resource = self::getResourceName();

                        return "$resource/$uuid/" . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
                    });
            } elseif ($value['type'] == 'bool') {
                $inputs[] = Toggle::make($key)
                    ->label($value['label'])
                    ->required($value['required']);
            } elseif ($value['type'] == 'text_json') {
                $inputs[] = Section::make($value['label'])
                    ->schema([
                        TextInput::make("$key" . '_fa')
                            ->label($value['label'] . '(' . __('langbtn.persian') . ')')
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_fa', json_decode($record->{$field})->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl'])
                            ->required($value['required']),
                        TextInput::make("$key" . '_en')
                            ->label($value['label'] . '(' . __('langbtn.english') . ')')
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_en', json_decode($record->{$field})->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr'])
                            ->required($value['required']),
                    ])
                    ->columns(2);
            } elseif ($value['type'] == 'textarea_json') {
                $inputs[] = Section::make($value['label'])
                    ->schema([
                        Textarea::make("$key" . '_fa')
                            ->label($value['label'] . '(' . __('langbtn.persian') . ')')
                            ->required($value['required'])
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_fa', json_decode($record->{$field})->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl'])
                            ->rows(7),
                        Textarea::make("$key" . '_en')
                            ->label($value['label'] . '(' . __('langbtn.english') . ')')
                            ->required($value['required'])
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_en', json_decode($record->{$field})->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr'])
                            ->rows(7),
                    ])
                    ->columns(2);
            } elseif ($value['type'] == 'richtext_json') {
                $inputs[] = Section::make($value['label'])
                    ->schema([
                        RichEditor::make("$key" . '_fa')
                            ->label($value['label'] . '(' . __('langbtn.persian') . ')')
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_fa', json_decode($record->{$field})->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl'])
                            ->required($value['required']),
                        RichEditor::make("$key" . '_en')
                            ->label($value['label'] . '(' . __('langbtn.english') . ')')
                            ->afterStateHydrated(function ($record, $set) use($key) {
                                $field = str_replace('_translated', '', $key);
                                !is_null($record) ? $set("$key" . '_en', json_decode($record->{$field})->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr'])
                            ->required($value['required']),
                    ])
                    ->columns(2);
            }
        }

        return $inputs;
    }

    protected static function autoCreateColumns(): array
    {
        self::getFields();
        $cols = [];
//        $model = Str::before(class_basename(static::class), 'Resource');
//        dd($model);

        foreach (self::$fields as $key => $value) {
            if (in_array($value['type'], self::$textTypes)) {
                $cols[] = TextColumn::make($key)
                                ->label($value['label'])
                                ->wrap()
                                ->limit(30)
                                ->html();
            } elseif ($value['type'] == 'image') {
                $cols[] = ImageColumn::make($key)
                                ->label($value['label']);
            } elseif ($value['type'] == 'bool') {
                $cols[] = ToggleColumn::make($key)
                                ->label($value['label']);
            } elseif ($value['type'] == 'bool_badge') {
                $cols[] = TextColumn::make($key)
                                ->label($value['label'])
                                ->badge()
                                ->formatStateUsing(fn (?YesNo $state) => $state?->label())
                                ->color(fn (?YesNo $state) => $state?->color());
            } elseif ($value['type'] == 'text_badge') {
                $enum = $value['enum'];
                $cols[] = TextColumn::make($key)
                    ->label($value['label'])
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof $enum ? $state->label() : null)
                    ->color(fn ($state) => $state instanceof $enum ? $state->color() : 'primary');
            }
        }

        return $cols;
    }

    protected static function autoCreateInfolist(): array
    {
        self::getFields();
        $cols = [];

        foreach (self::$fields as $key => $value) {
            if (in_array($value['type'], self::$textTypes)) {
                $cols[] = TextEntry::make($key)
                    ->label($value['label'])
                    ->html();
            } elseif ($value['type'] == 'image') {
                $cols[] = ImageEntry::make($key)
                    ->label($value['label']);
            } elseif ($value['type'] == 'bool_badge') {
                $cols[] = TextEntry::make($key)
                    ->label($value['label'])
                    ->badge()
                    ->formatStateUsing(fn (?YesNo $state) => $state?->label())
                    ->color(fn (?YesNo $state) => $state?->color());
            } elseif ($value['type'] == 'text_badge') {
                $enum = $value['enum'];
                $cols[] = TextEntry::make($key)
                    ->label($value['label'])
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof $enum ? $state->label() : null)
                    ->color(fn ($state) => $state instanceof $enum ? $state->color() : 'primary');
            }
        }

        return $cols;
    }

    public static function getLabel(): ?string
    {
        return __("filament::resources.".self::getResourceName().".label");
    }

    public static function getPluralLabel(): ?string
    {
        return __("filament::resources.".self::getResourceName().".plural_label");
    }

    public static function getModelLabel(): string
    {
        return __("filament::resources.".self::getResourceName().".model_label");
    }
}
