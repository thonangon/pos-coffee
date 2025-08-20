<?php

namespace App\Livewire\Categories;

use App\Models\ItemCategory;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class CreateItemCategories extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }
    public function form(Schema $schema): Schema {
        return $schema
            ->components([
                Section::make('Add Item Category')
                    ->description('Fill the form to add new item category')
                    ->columns(2)
                    ->schema([
                        TextInput::make('category_name')
                            ->label('Category Name')
                            ->required(),
                        
                    ])
            ])
            ->statePath('data')
            ->model(ItemCategory::class);       

    }
    public function create(): void
    {
        $data = $this->form->getState();

        $record = ItemCategory::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Item Category Created!')
            ->success()
            ->body("Item Category Created successfully!")
            ->send();
    }
    public function render()
    {
        return view('livewire.categories.create-item-categories');
    }
}
