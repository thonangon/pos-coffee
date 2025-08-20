<?php

namespace App\Livewire\Menus;

use App\Models\Menu;
use Filament\Actions\Action;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;

use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListMenu extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;
    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Menu::query())
            ->columns([
                TextColumn::make('menu_name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // Define any filters here if needed
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add New')
                    ->url(fn(): string => route('menus.create'))
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn(Menu $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('Deleted successfully')
                            ->success()
                    ),
                Action::make('edit')
                    ->url(fn(Menu $record): string => route('item.update', $record))
            ]);
    }
    public function render()
    {
        return view('livewire.menus.list-menu');
    }
}
