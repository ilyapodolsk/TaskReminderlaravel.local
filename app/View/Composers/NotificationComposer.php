<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view) {
        $hasNotifications = Task::where('user_id', Auth::id())
            ->where('status', 'В процессе')
            ->where('deadline', '<', now()->addDays(3))
            ->exists();

        $view->with('hasNotifications', $hasNotifications);
    }
}