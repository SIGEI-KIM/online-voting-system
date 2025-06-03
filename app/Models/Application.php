<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'election_id',
        'applied_at',
        'status',
        'full_name',        
        'id_number',         
        'contact_email',     
        'contact_phone',     
        'passport_photo_path', 
        'document_path',     
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }
}