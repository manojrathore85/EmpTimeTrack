<?php

namespace App\Livewire;

use App\Models\Subproject;
use App\Models\Timelog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TimeLogTable extends Component
{
    use WithPagination;
    public $idToDelete;
    public $timeLogId;
    public $editMode = false;
    public $showDeleteModal = false;
    public $subprojects;
    public $users;
    public $timeLogFields = [
        'subproject_id' => '',
        'user_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'total_hours' => '',
    ];

    // Define validation rules
    protected $rules = [
        'timeLogFields.subproject_id' => 'required',
        'timeLogFields.user_id' => 'required',
        'timeLogFields.date' => 'required',
        'timeLogFields.start_time' => 'required',
        'timeLogFields.end_time' => 'required',
        'timeLogFields.total_hours' => 'required',
 
        
    ];

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $admin = '';

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 5;


    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function confirmDelete($id)
    {
        $this->idToDelete = $id;
        $this->showDeleteModal = true;
    }
    public function delete()
    {
        TimeLog::find($this->idToDelete)->delete();
        $this->showDeleteModal = false;
        session()->flash('message', 'Time Log deleted successfully.');
        
    }

    public function setSortBy($sortByField)
    {

        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        return view(
            'livewire.time-log-table',
            [
                'timelogs' => $this->getTimeLog(),
                'users' => $this->users,
                'subprojects' => $this->subprojects, // Fetching all subprojects for the dropdown
                'editMode' => $this->editMode, // Sending edit mode status to the view
            ]
        );
    }
    public function getTimeLog()
    {
        return TimeLog::query()->with('subproject', 'user', 'subproject.project.department')
            ->when(Auth::user()->hasRole('employee'), function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                // Search in related models: subproject name, user name, and department name
                $query->whereHas('subproject', function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('subproject.project.department', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->sortBy, function ($query) {
                // Sorting logic based on related fields
                if ($this->sortBy === 'subproject_name') {
                    $query->join('subprojects', 'timelogs.subproject_id', '=', 'subprojects.id')
                        ->orderBy('subprojects.name', $this->sortDir);
                } elseif ($this->sortBy === 'user_name') {
                    $query->join('users', 'timelogs.user_id', '=', 'users.id')
                        ->orderBy('users.name', $this->sortDir);
                } elseif ($this->sortBy === 'department_name') {
                    $query->join('subprojects', 'timelogs.subproject_id', '=', 'subprojects.id')
                        ->join('projects', 'subprojects.project_id', '=', 'projects.id')
                        ->join('departments', 'projects.department_id', '=', 'departments.id')
                        ->orderBy('departments.name', $this->sortDir);
                } else {
                    // Default sorting by fields in the time_logs table
                    $query->orderBy($this->sortBy, $this->sortDir);
                }
            })
            ->paginate($this->perPage);
    }
    public function editTimeLog($id)
    {
        $this->timeLogId = $id;
        $this->editMode = true;

        // Load the existing data into the form fields
        $timeLog = TimeLog::findOrFail($id);
        $this->timeLogFields = [
            'subproject_id' => $timeLog->subproject_id,
            'user_id' => $timeLog->user_id,
            'date' => $timeLog->date,
            'start_time' => $timeLog->start_time,
            'end_time' => $timeLog->end_time,
            'total_hours' => $timeLog->total_hours,
           
        ];
        //dd($timeLog);
    }
    public function updateTimeLog()
    {
        // Validate the form data
        $this->validate();
       
        // Find the time log and update its data
        $timeLog = TimeLog::findOrFail($this->timeLogId);
        $timeLog->update([
            'subproject_id' => $this->timeLogFields['subproject_id'],
            'user_id' => $this->timeLogFields['user_id'],
            'date' => $this->timeLogFields['date'],
            'start_time' => $this->timeLogFields['start_time'],
            'end_time' => $this->timeLogFields['end_time'],
            'total_hours' => $this->timeLogFields['total_hours'],
           
        ]);

        // Close the edit modal
        $this->editMode = false;

        // Optionally refresh the list of time logs
        $this->getTimeLog();

        // Display success message
        session()->flash('message', 'Time log updated successfully.');
    }
    public function mount()
    {
        $this->subprojects = Subproject::all(); // Fetch all subprojects
        $this->users = User::all();             // Fetch all users
    }
}
