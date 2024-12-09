<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Event $event)
    {
        return true;
    }

    public function create(User $user)
    {
        return in_array($user->user_type, ['admin', 'super_admin']);
    }

    public function update(User $user, Event $event)
    {
        return in_array($user->user_type, ['admin', 'super_admin']);
    }

    public function delete(User $user, Event $event)
    {
        return in_array($user->user_type, ['admin', 'super_admin']);
    }
}