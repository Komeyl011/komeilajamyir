<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostTranslationResource\Pages;
use App\Filament\Resources\PostTranslationResource\RelationManagers;
use App\Http\Middleware\LanguageMiddleware;
use App\Models\Post;
use App\Models\PostTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostTranslationResource extends BaseResource
{
    protected static ?string $model = PostTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('filament::resources.groups.blog');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('post_id')
                    ->label(__('filament::resources.post-translation.table.post.label'))
                    ->options(fn () => Post::all()->mapWithKeys(function ($post) {
                        return [$post->id => $post->title_translated];
                    }))
                    ->required(),
                Forms\Components\Select::make('locale')
                    ->label(__('filament::resources.post-translation.table.locale.label'))
                    ->options(function () {
                        $locales = [];
                        $available_locales = LanguageMiddleware::scanLanguages();
                        foreach ($available_locales as $locale) {
                            $locales[$locale] = __("langbtn.$locale");
                        }
                        return $locales;
                    })
                    ->required(),
                Forms\Components\Textarea::make('excerpt')
                    ->label(__('filament::resources.post-translation.table.excerpt.label'))
                    ->maxLength(255)
                    ->rows(10)
                    ->required()
                    ->live()
                    ->extraAttributes(fn ($get) => $get('locale') == 'fa' ? ['dir' => 'rtl'] : ['dir' => 'ltr']),
                Forms\Components\RichEditor::make('body')
                    ->label(__('filament::resources.post-translation.table.body.label'))
                    ->columnSpan(2)
                    ->required()
                    ->live()
                    ->extraAttributes(fn ($get) => $get('locale') == 'fa' ? ['dir' => 'rtl'] : ['dir' => 'ltr']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                parent::autoCreateColumns()
            )
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->label(__('filament::resources.post-translation.table.locale.label'))
                    ->options(function () {
                        $locales = [];
                        $available_locales = LanguageMiddleware::scanLanguages();
                        foreach ($available_locales as $locale) {
                            $locales[$locale] = __("langbtn.$locale");
                        }
                        return $locales;
                    }),
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
        return $infolist->schema([
            TextEntry::make('post.title_translated')
                ->label(__('filament::resources.post-translation.table.post.label')),
            TextEntry::make('locale')
                ->label(__('filament::resources.post-translation.table.locale.label')),
            TextEntry::make('excerpt')
                ->label(__('filament::resources.post-translation.table.excerpt.label'))
                ->extraAttributes(fn ($record) => $record->locale == 'fa' ? ['dir' => 'rtl'] : ['dir' => 'ltr']),
            TextEntry::make('body')
                ->label(__('filament::resources.post-translation.table.body.label'))
                ->html()
                ->extraAttributes(fn ($record) => $record->locale == 'fa' ? ['dir' => 'rtl'] : ['dir' => 'ltr']),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostTranslations::route('/'),
            'view' => Pages\ViewPostTranslation::route('/{record}/view'),
            'create' => Pages\CreatePostTranslation::route('/create'),
            'edit' => Pages\EditPostTranslation::route('/{record}/edit'),
        ];
    }
}
