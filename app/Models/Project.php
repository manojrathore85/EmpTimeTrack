<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function subproject(): HasMany
    {
        return $this->hasMany(Subproject::class);
    }
}
