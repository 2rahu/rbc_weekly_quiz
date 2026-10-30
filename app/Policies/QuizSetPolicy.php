<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuizSet;

class QuizSetPolicy
{
  public function before(User $user, string $ability): ?bool
    {
        return $user->roles?->role === 'admin' ? true : false;
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, QuizSet $quizSet): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, QuizSet $quizSet): bool
    {
        return false;
    }

    public function delete(User $user, QuizSet $quizSet): bool
    {
        return false;
    }
    
}