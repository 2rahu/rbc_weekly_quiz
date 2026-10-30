<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Roles;
use App\Models\QuizSet;
use App\Models\QuizTopic;
use App\Models\QuizEditor;
use App\Policies\UserPolicy;
use App\Policies\RolesPolicy;
use App\Policies\TopicPolicy;
use App\Policies\QuizSetPolicy;
use App\Policies\QuizEditorPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
    }


    public function boot(): void
    {
         Gate::policy(QuizTopic::class, TopicPolicy::class);
         Gate::policy(User::class, UserPolicy::class);
         Gate::policy(Roles::class, RolesPolicy::class);
         Gate::policy(QuizSet::class, QuizSetPolicy::class);
         Gate::policy(QuizEditor::class, QuizEditorPolicy::class);



    }
}
