<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Tables;
use App\Models\Timelog;
use Filament\Support\Contracts\TranslatableContentDriver; 

class TimeLogTable extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    

    protected function getTableQuery()
    {
        return Timelog::query()->with(['subproject', 'user']); 
    }

    protected function getTableColumns()
    {
        return [
            Tables\Columns\TextColumn::make('id')->label('ID'),
            Tables\Columns\TextColumn::make('user.name')->label('User'),
            Tables\Columns\TextColumn::make('subproject.name')->label('Subproject'),
            Tables\Columns\TextColumn::make('date')->label('Date'),
            Tables\Columns\TextColumn::make('start_time')->label('Start Time'),
            Tables\Columns\TextColumn::make('end_time')->label('End Time'),
            Tables\Columns\TextColumn::make('total_hours')->label('Total Hours'),
            
        ];
    }

    
    public function makeFilamentTranslatableContentDriver(): ? TranslatableContentDriver
    {
        return null; 
    }

    public function render()
    {
        return view('livewire.time-log-table');
    }
}
