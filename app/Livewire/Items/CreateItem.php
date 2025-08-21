<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Livewire\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Components\ToggleButtons;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\FileUpload;


class CreateItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    protected static ?string $model = Item::class;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Add the Item')
                    ->description('fill the form to add new item')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Item Name')
                            ->required(),
                        TextInput::make('sku')
                            
                            ->disabled() // Assuming SKU is auto-generated and should not be editable
                            ->helperText('Sku is auto-generated and cannot be changed.'),

                        TextInput::make('price')
                            ->prefix('$')
                            ->required()
                            ->numeric(),
                        Select::make('item_category_id')
                            ->relationship('category', 'category_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('menu_id')
                            ->relationship('menu', 'menu_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('description')
                            ->label('Description')
                            ->nullable()
                            ->maxLength(500)
                            ->helperText('A brief description of the item.'),
                        FileUpload::make('image')
                            ->label('Item Image')
                            ->image()
                            ->disk('public')
                            ->directory('items')
                            ->maxSize(2048)
                            ->imagePreviewHeight('150') // preview size
                            ->preserveFilenames(), // optional

                        ToggleButtons::make('status')
                            ->label('Is this Item Active?')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'In Active',
                            ])
                            ->default('active')
                            ->grouped()
                    ])
            ])
            ->statePath('data')
            ->model(Item::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Item::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Item Created!')
            ->success()
            ->body("Item created successfully!")
            ->send();
    }

    public function render(): View
    {
        return view('livewire.items.create-item');
    }
}
