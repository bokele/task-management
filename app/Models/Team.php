<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'project_id', 'team_leader_id', 'team_leader_assistance_id', 'code', 'name'
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function teamLeader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_leader_id', 'id');
    }
    public function teamLeaderAssistance(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_leader_assistance_id', 'id');
    }
}
