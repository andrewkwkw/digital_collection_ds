<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;

class ArchivePolicy
{
    public function view(User $user, Archive $archive): bool
    {
        return in_array($user->role, ['admin', 'superadmin']);
    }

    public function update(User $user, Archive $archive): bool
    {
        return in_array($user->role, ['admin', 'superadmin']);
    }

    public function delete(User $user, Archive $archive): bool
    {
        return in_array($user->role, ['admin', 'superadmin']);
    }
}
