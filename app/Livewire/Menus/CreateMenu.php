<?php

namespace App\Livewire\Menus;

use App\Models\Menu;
use Livewire\Component;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Contracts\HasTable;

class CreateMenu extends Component implements HasSchemas, HasActions, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
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
                Section::make('Add Menu')
                    ->description('Fill the form to add new menu')
                    ->columns(2)
                    ->schema([
                        TextInput::make('menu_name')
                            ->label('Menu Name')
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model(Menu::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Menu::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Menu Created!')
            ->success()
            ->body("Menu Created successfully!")
            ->send();
    }

    public function render()
    {
        return view('livewire.menus.create-menu');
    }
}
