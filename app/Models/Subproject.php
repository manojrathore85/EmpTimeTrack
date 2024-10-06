<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subproject extends Model
{
    use HasFactory;
    public function timelog(): HasMany
    {
        return $this->hasMany(Timelog::class);
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
