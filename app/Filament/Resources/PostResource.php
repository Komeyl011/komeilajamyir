<?php

namespace App\Filament\Resources;

use App\Enum\PublishStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends BaseResource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.blog');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('filament::resources.post.table.title_translated.label'))
                    ->schema([
                        Forms\Components\TextInput::make('title_translated_en')
                            ->label(__('filament::resources.post.table.title_translated.label') . ' (' . __('langbtn.english') . ')')
                            ->required()
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("title_translated_en", json_decode($record->title)->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr']),
                        Forms\Components\TextInput::make('title_translated_fa')
                            ->label(__('filament::resources.post.table.title_translated.label') . ' (' . __('langbtn.persian') . ')')
                            ->required()
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("title_translated_fa", json_decode($record->title)->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl']),

                        Forms\Components\TextInput::make('seo_title_translated_en')
                            ->label(__('filament::resources.post.table.seo_title_translated.label') . ' (' . __('langbtn.english') . ')')
                            ->required()
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("seo_title_translated_en", json_decode($record->seo_title)->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr']),
                        Forms\Components\TextInput::make('seo_title_translated_fa')
                            ->label(__('filament::resources.post.table.seo_title_translated.label') . ' (' . __('langbtn.persian') . ')')
                            ->required()
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("seo_title_translated_fa", json_decode($record->seo_title)->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl']),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('filament::resources.post.table.meta_description_translated.label'))
                    ->schema([
                        Forms\Components\TextInput::make('meta_description_translated_en')
                            ->required()
                            ->label(__('filament::resources.post.table.meta_description_translated.label') . ' (' . __('langbtn.english') . ')')
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("meta_description_translated_en", json_decode($record->meta_description)->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr']),
                        Forms\Components\TextInput::make('meta_description_translated_fa')
                            ->required()
                            ->label(__('filament::resources.post.table.meta_description_translated.label') . ' (' . __('langbtn.persian') . ')')
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("meta_description_translated_fa", json_decode($record->meta_description)->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl']),

                        Forms\Components\TextInput::make('meta_keywords_translated_en')
                            ->required()
                            ->label(__('filament::resources.post.table.meta_keywords_translated.label') . ' (' . __('langbtn.english') . ')')
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("meta_keywords_translated_en", json_decode($record->meta_keywords)->en) : '';
                            })
                            ->extraAttributes(['dir' => 'ltr']),
                        Forms\Components\TextInput::make('meta_keywords_translated_fa')
                            ->required()
                            ->label(__('filament::resources.post.table.meta_keywords_translated.label') . ' (' . __('langbtn.persian') . ')')
                            ->afterStateHydrated(function ($record, $set) {
                                !is_null($record) ? $set("meta_keywords_translated_fa", json_decode($record->meta_keywords)->fa) : '';
                            })
                            ->extraAttributes(['dir' => 'rtl']),
                    ])
                    ->columns(2),

                Forms\Components\FileUpload::make('image')
                    ->label(__('filament::resources.post.table.image.label'))
                    ->required()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->rules(['mimes:jpg,jpeg,png'])
                    ->disk('liara')
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        $uuid = Str::uuid();
                        $resource = self::getResourceName();

                        return "$resource/$uuid/" . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->label(__('filament::resources.post.table.slug.label'))
                    ->extraAttributes(['dir' => 'ltr']),

                Forms\Components\Select::make('category_id')
                    ->label(__('filament::resources.post.table.category.label'))
                    ->required()
                    ->options(fn () => Category::query()->pluck('name', 'id')),
                Forms\Components\Select::make('status')
                    ->label(__('filament::resources.post.table.status.label'))
                    ->required()
                    ->options(fn () => PublishStatus::labels()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns()
            )
            ->searchable()
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label(__('filament::resources.post.table.category.label'))
                    ->options(fn () => Category::query()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('filament::resources.post.table.status.label'))
                    ->options(fn () => PublishStatus::labels()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(
            parent::autoCreateInfolist()
        );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
