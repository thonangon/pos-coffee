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
use Filament\Tables\Columns\ImageColumn;

class CreateItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

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
                            ->required()
                            ->unique(),
                        TextInput::make('price')
                            ->prefix('$')
                            ->required()
                            ->numeric(),
                        Select::make('category_id')
                            ->relationship('category', 'category_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('menu_id')
                            ->relationship('menu', 'menu_name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        
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
