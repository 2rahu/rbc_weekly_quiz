<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuizEditor;

class QuizEditorPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        // Admin can perform every action
        if ($user->roles?->role === 'admin') {
            return true;
        }

        // Other users will be checked by individual policy methods
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->roles?->role === 'user';
    }

    public function view(User $user, QuizEditor $quizEditor): bool
    {
        return $user->roles?->role === 'user';
    }

    public function create(User $user): bool
    {
        return $user->roles?->role === 'user';
    }

    public function update(User $user, QuizEditor $quizEditor): bool
    {
        return $user->roles?->role === 'user';
    }

    public function delete(User $user, QuizEditor $quizEditor): bool
    {
        return false;
    }
}
