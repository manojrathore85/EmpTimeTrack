<?php
namespace App\Exports;

use App\Models\Timelog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TimeLogExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Timelog::with('subproject', 'user', 'subproject.project.department')
            ->get(['id', 'subproject_id', 'user_id', 'date', 'start_time', 'end_time', 'total_hours', 'created_at', 'updated_at'])
            ->map(function ($timelog) {
                return [
                    'id' => $timelog->id,
                    'user_name' => $timelog->user->name, 
                    'subproject_name' => $timelog->subproject->name, 
                    'date' => $timelog->date,
                    'start_time' => $timelog->start_time,
                    'end_time' => $timelog->end_time,
                    'total_hours' => $timelog->total_hours,
                    'created_at' => $timelog->created_at,
                    'updated_at' => $timelog->updated_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'User',
            'Subproject',
            'Date',
            'Start Time',
            'End Time',
            'Total Hours',
            'Created At',
            'Updated At',
        ];
    }
}