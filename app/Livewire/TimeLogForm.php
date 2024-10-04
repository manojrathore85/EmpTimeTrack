<?php
namespace App\Livewire;

use Livewire\Component;
use Filament\Forms;
use App\Models\Department;
use App\Models\Project;
use App\Models\Subproject;
use App\Models\Timelog;
use Carbon\Carbon;

class TimeLogForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $department_id;
    public $project_id;
    public $subproject_id;
    public $date;
    public $start_time;
    public $end_time;
    public $total_hours;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('department_id')
                ->label('Department')
                ->options(Department::all()->pluck('name', 'id')->toArray())
                ->reactive()
                ->required(),

            Forms\Components\Select::make('project_id')
                ->label('Project')
                ->options(function (callable $get) {
                    return Project::where('department_id', $get('department_id'))->pluck('name', 'id');
                })
                ->reactive()
                ->required(),

            Forms\Components\Select::make('subproject_id')
                ->label('Subproject')
                ->options(function (callable $get) {
                    return Subproject::where('project_id', $get('project_id'))->pluck('name', 'id');
                })
                ->required(),

            Forms\Components\DatePicker::make('date')
                ->label('Date')
                ->required(),

            Forms\Components\TimePicker::make('start_time')
                ->label('Start Time')
                ->required(),

            Forms\Components\TimePicker::make('end_time')
                ->label('End Time')
                ->required(),
        ];
    }

    public function save()
    {
        $this->validate();

        $this->total_hours = Carbon::parse($this->start_time)->diffInHours(Carbon::parse($this->end_time));

        Timelog::create([
            'user_id' => auth()->user()->id,
            'subproject_id' => $this->subproject_id,
            'date' => $this->date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'total_hours' => $this->total_hours,
        ]);

        session()->flash('message', 'Time log saved successfully.');
        $this->reset([
            'department_id',
            'project_id',
            'subproject_id',
            'date',
            'start_time',
            'end_time',
            'total_hours',
        ]);
    }

    public function render()
    {
        
        return view('livewire.time-log-form')->layout('layouts.app');
    }
}
