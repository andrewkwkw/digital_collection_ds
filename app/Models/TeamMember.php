<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo_path',
        'education',
        'nidn',
        'nip',
        'sinta_id',
        'scholar_id',
        'scopus_id',
        'orcid_id',
        'publon_id',
        'expertise',
        'research_focus',
        'cv_path',
        'email',
        'order'
    ];
}
