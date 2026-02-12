<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Archive extends Model
{
    protected $fillable = [
        'user_id',
        'number',
        'title',
        'creator',
        'subject',
        'description',
        'publisher',
        'contributor',
        'date',
        'type',
        'format',
        'source',
        'relation',
        'reach',
        'rights',
    ];

    protected $casts = [
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ArchiveFile::class)->orderBy('order');
    }

    // Keep images() for backward compatibility
    public function images(): HasMany
    {
        return $this->files();
    }
}
