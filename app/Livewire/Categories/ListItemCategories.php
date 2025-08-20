<?php

namespace App\Livewire\Categories;

use App\Models\ItemCategory;
use Filament\Actions\Action;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Illuminate\Database\Eloquent\Builder;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;

class ListItemCategories extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => ItemCategory::query())
            ->columns([
                TextColumn::make('category_name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            
            ->headerActions([
                Action::make('create')
                    ->label('Add New Category')
                    ->url(fn(): string => route('create_item_categories.create'))
            ])
            ->recordActions([
                Action::make('edit')
                    ->action(fn(ItemCategory $record) => redirect()->route('create_item_categories.create', $record))
                    ->icon('heroicon-o-pencil'),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn(ItemCategory $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('Success')
                            ->body('Category deleted successfully!')
                            ->success()
                    ),

            ]);
            
    }


    public function render()
    {
        return view('livewire.categories.list-item-categories');
    }
}
