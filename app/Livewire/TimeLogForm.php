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


    protected function customValidation()
    {
        $this->validate([
            'start_time' => 'required',
            'end_time' => function ($attribute, $value, $fail) {
                $start = Carbon::createFromFormat('H:i:s', $this->start_time);
                $end = Carbon::createFromFormat('H:i:s', $value);

                if ($end->lessThanOrEqualTo($start)) {
                    $fail('The End Time must be greater than Start Time.');
                }
            },
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make() 
                ->columns([
                    'xs' => 1, 
                    'sm' => 2, 
                    'md' => 3, 
                    'lg' => 4, 
                ])
                ->schema([
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

                    // Forms\Components\TimePicker::make('end_time')
                    //     ->label('End Time')
                    //     ->required(),
    
                    Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->required()
                    ->validationAttribute('End Time')
                    // ->reactive()                    
                    // ->afterStateUpdated(function ($set, $get) {
                    //     $startTime = $get('start_time');
                    //     $endTime = $get('end_time');

                    //     // Check if both start and end times are set
                    //     if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $get('start_time')) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $get('end_time'))) {
                    //         $start = \Carbon\Carbon::createFromFormat('H:i:s', $get('start_time'));
                    //         $end = \Carbon\Carbon::createFromFormat('H:i:s', $get('end_time'));                        

                    //         // Validate that end time is greater than start time
                    //         if ($end->lessThanOrEqualTo($start)) {
                    //             $set('end_time_error', 'The End Time must be greater than Start Time.');
                    //             $set('total_hours', null); // Reset total hours if times are invalid
                    //         } else {                                
                    //             $set('end_time_error', null);                              

                    //             // Calculate the difference in hours and minutes
                    //             $differenceInMinutes = $end->diffInMinutes($start);                                
                    //             $hoursDiff = $end->diffInHours($start);
                    //             $set('total_hours', $hoursDiff);                            
                    //         }
                    //     }
                    // }),
                    // Forms\Components\TextInput::make('total_hours')
                    // ->label('Total Hour')
                    // ->required()  
                    // ->numeric()
                    // ->minValue(0)
                    // ->maxValue(24),              
                ])
        ];
    }

    public function save()
    {
        $this->validate();
        $this->customValidation();

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
