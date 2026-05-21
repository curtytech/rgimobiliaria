<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Sobre a Empresa';

    protected static ?string $modelLabel = 'Sobre';

    protected static ?string $pluralModelLabel = 'Sobre a Empresa';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informacoes da Empresa')
                ->schema([
                    TextInput::make('enterprise_name')
                        ->label('Nome da Empresa')
                        ->required()
                        ->minLength(3)
                        ->maxLength(255),

                    Textarea::make('description')
                        ->label('Descricao')
                        ->required()
                        ->rows(4)
                        ->minLength(10)
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('contact')
                        ->label('Responsavel / Contato')
                        ->required()
                        ->minLength(3)
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Contato')
                ->schema([
                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->validationMessages([
                            'email' => 'Informe um e-mail valido.',
                        ]),

                    TextInput::make('phone')
                        ->label('Telefone')
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->rule('regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/')
                        ->placeholder('(21) 98136-6864')
                        ->helperText('Use DDD e numero com 8 ou 9 digitos.')
                        ->validationMessages([
                            'regex' => 'Informe um telefone valido. Exemplo: (21) 98136-6864',
                        ]),

                    TextInput::make('video_link')
                        ->label('Link do Video')
                        ->url()
                        ->required()
                        ->maxLength(255)
                        ->placeholder('https://www.youtube.com/watch?v=VIDEO_ID')
                        ->validationMessages([
                            'url' => 'Informe uma URL valida para o video.',
                        ])
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Endereco')
                ->schema([
                    TextInput::make('address')
                        ->label('Endereco')
                        ->required()
                        ->minLength(5)
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('city')
                        ->label('Cidade')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255),

                    Select::make('state')
                        ->label('Estado')
                        ->required()
                        ->options(self::getStateOptions())
                        ->searchable(),

                    TextInput::make('zip')
                        ->label('CEP')
                        ->required()
                        ->maxLength(9)
                        ->rule('regex:/^\d{5}-?\d{3}$/')
                        ->placeholder('00000-000')
                        ->validationMessages([
                            'regex' => 'Informe um CEP valido. Exemplo: 20020-010',
                        ]),

                    Select::make('country')
                        ->label('Pais')
                        ->required()
                        ->options(self::getCountryOptions())
                        ->default('Brasil')
                        ->searchable(),
                ])
                ->columns(2),

            Section::make('Midia')
                ->schema([
                    FileUpload::make('logo')
                        ->label('Logo')
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->image()
                        ->disk('public')
                        ->directory('about')
                        ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                        ->rules(['mimes:webp,png,jpg,jpeg'])
                        ->maxSize(20480)
                        ->maxFiles(1),

                    // FileUpload::make('banner')
                    //     ->label('Banner')
                    //     ->required(fn (string $operation): bool => $operation === 'create')
                    //     ->image()
                    //     ->imageEditor()
                    //     ->disk('public')
                    //     ->directory('about')
                    //     ->acceptedFileTypes(['image/webp', 'image/png', 'image/jpeg', 'image/jpg'])
                    //     ->rules(['mimes:webp,png,jpg,jpeg'])
                    //     ->maxSize(20480)
                    //     ->maxFiles(1),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),

                TextColumn::make('enterprise_name')
                    ->label('Empresa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact')
                    ->label('Contato')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Telefone')
                    ->searchable(),

                TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('state')
                    ->label('Estado')
                    ->badge(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    protected static function getStateOptions(): array
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapa',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceara',
            'DF' => 'Distrito Federal',
            'ES' => 'Espirito Santo',
            'GO' => 'Goias',
            'MA' => 'Maranhao',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Para',
            'PB' => 'Paraiba',
            'PR' => 'Parana',
            'PE' => 'Pernambuco',
            'PI' => 'Piaui',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondonia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina',
            'SP' => 'Sao Paulo',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins',
        ];
    }

    protected static function getCountryOptions(): array
    {
        return [
            'Brasil' => 'Brasil',
            'Argentina' => 'Argentina',
            'Chile' => 'Chile',
            'Estados Unidos' => 'Estados Unidos',
            'Portugal' => 'Portugal',
            'Espanha' => 'Espanha',
        ];
    }
}
