<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Livewire\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Components\Section;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Components\ToggleButtons;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class EditItem extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Item $record;

    public ?array $data = [];

    public function mount(): void
    {
        //it populate the default values from db
        $this->form->fill($this->record->attributesToArray());
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
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $this->record->update($data);

        Notification::make()
            ->title('Item Updated!')
            ->success()
            ->body("Item {$this->record->name} has been updated successfully!")
            ->send();
    }

    public function render(): View
    {
        return view('livewire.items.edit-item');
    }
}
