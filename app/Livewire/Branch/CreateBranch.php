<?php

namespace App\Livewire\Branch;

use App\Models\Branches;
use Livewire\Component;

use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Forms\Components\ToggleButtons;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;

class CreateBranch extends Component implements HasActions, HasSchemas
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
                Section::make('Add New Branch')
                    ->description('fill the form to add new branch')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Branch Name')
                            ->required(),
                        
                        TextInput::make('address')
                            ->label('Address')
                            ->nullable()
                            ->numeric(),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->required()
                            ->numeric(),
                        
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->nullable()
                            ->maxLength(500),
                           
                        FileUpload::make('image')
                            ->label('Item Image')
                            ->image()
                            ->disk('public')
                            ->directory('items')
                            ->maxSize(2048)
                            ->imagePreviewHeight('150') 
                            ->preserveFilenames(), 

                        ToggleButtons::make('is_avaialable')
                            ->label('Is this is Active?')
                            ->options([
                                'active' => 'Available',
                                'inactive' => 'Unavialable',
                            ])
                            ->default('available')
                            ->grouped()
                    ])
            ])
            ->statePath('data')
            ->model(Branches::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Branches::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Branch Created!')
            ->success()
            ->body("Branch created successfully!")
            ->send();
    }
    public function render(): View
    {
        return view('livewire.branch.create-branch');
    }
}
