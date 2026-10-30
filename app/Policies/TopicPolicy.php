<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuizTopic;

class TopicPolicy
{
    public function before(User $user, string $ability): ?bool
    {
         if ($user->roles?->role === 'admin') {
            return true;
        }

        // Other users will be checked by individual policy methods
        return null;

    }

    public function viewAny(User $user): bool
    {
        return in_array($user->roles?->role, ['admin', 'user'], true);
    }

    public function view(User $user, QuizTopic $quizTopic): bool
    {
        return in_array($user->roles?->role, ['admin', 'user'], true);
    }

    public function create(User $user): bool
    {
        return in_array($user->roles?->role, ['admin', 'user'], true);
    }

    public function update(User $user, QuizTopic $quizTopic): bool
    {
        return in_array($user->roles?->role, ['admin', 'user'], true);
    }

    public function delete(User $user, QuizTopic $quizTopic): bool
    {
        return false;
    }
}