<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timelog extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'subproject_id',
        'date',
        'start_time',
        'end_time',
        'total_hours',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function subproject(): BelongsTo
    {
        return $this->belongsTo(Subproject::class);
    }
    public function scopeSearch($query, $value){
        $query->where('user_id',$value);
    }
}
