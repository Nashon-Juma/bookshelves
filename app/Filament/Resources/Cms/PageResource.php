<?php

namespace App\Filament\Resources\Cms;

use App\Enums\TemplateEnum;
use App\Filament\LayoutHelper;
use App\Filament\Resources\Cms\PageResource\Pages;
use App\Filament\PageHelper;
use App\Models\Cms\Page;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Str;
use Whoops\Util\TemplateHelper;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'CMS';

    public static function form(Form $form): Form
    {
        // return LayoutHelper::columns($form, [
        //     LayoutHelper::mainColumn(
        //         [
        //             Forms\Components\TextInput::make('title')
        //                 ->label('Title'),
        //         ]
        //     ),
        //     LayoutHelper::sideColumn(
        //         []
        //     )
        // ]);

        return LayoutHelper::column($form, [
            LayoutHelper::fullColumn(
                [
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                            $name = Str::slug($state);
                            $lang = $get('language');
                            $set('name', $name);
                            $set('slug', "{$name}_{$lang}");
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->disabled(),
                    Forms\Components\Select::make('language')
                        ->options([
                            'en' => 'English',
                            'fr' => 'Français',
                        ])
                        ->label('Language')
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                            $name = $get('name');
                            $lang = $state;
                            $set('slug', "{$name}_{$lang}");
                        }),
                    Forms\Components\Select::make('type')
                        ->options(TemplateEnum::toList())
                        ->label('Type')
                        ->helperText('Select type of template.')
                        ->default(TemplateEnum::basic->value)
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set) {
                            $set('content', []);
                        }),
                    Forms\Components\Repeater::make('content')
                        ->schema(function (Closure $get) {
                            $method = $get('type');
                            return TemplateHelper::{$method}();
                        })
                        ->columns(1)
                        ->maxItems(1)
                        ->orderable(fn () => false)
                        ->columnSpan(2),
                ]
            ),
            LayoutHelper::sideColumn(
                []
            ),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'primary',
                        'success' => TemplateEnum::basic,
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('language')
                    ->label('Language')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
        ;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
