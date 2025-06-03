<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'election_id',
        'user_id',
        'position',
        'bio',
        'photo',
    ];
    /**
     * Get the election that the candidate belongs to.
     */
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    /**
     * Get the votes for the candidate.
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}