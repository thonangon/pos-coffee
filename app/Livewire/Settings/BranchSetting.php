<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Branches;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Actions\Action;


class BranchSetting extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Branches::query())
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->width(100)
                    ->height(70)
                    ->circular(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('is_available')
                    ->badge(),
            ])
            ->filters([])
            ->headerActions([
                Action::make('create')
                    ->label('Add New Branch')
                    ->url(fn(): string => route('branch.create'))
            ])
            ->recordActions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn(Branches $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('Deleted successfully')
                            ->success()
                    ),
                Action::make('edit')
                    ->url(fn(Branches $record): string => route('branch.update', $record))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.settings.branch-setting');
    }
}