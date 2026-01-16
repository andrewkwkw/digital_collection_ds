<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;

class ArchivePolicy
{
    public function view(User $user, Archive $archive): bool
    {
        return $user->id === $archive->user_id || $user->isSuperAdmin();
    }

    public function update(User $user, Archive $archive): bool
    {
        return $user->id === $archive->user_id || $user->isSuperAdmin();
    }

    public function delete(User $user, Archive $archive): bool
    {
        return $user->id === $archive->user_id || $user->isSuperAdmin();
    }
}
