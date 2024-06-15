<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Item $item): bool
    {
        $budget = $item->budget;
        assert($budget instanceof Budget);

        return $budget->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Item $item): bool
    {
        return $this->view($user, $item);
    }

    public function delete(User $user, Item $item): bool
    {
        return $this->view($user, $item);
    }

    public function restore(User $user, Item $item): bool
    {
        return $this->view($user, $item);
    }

    public function forceDelete(User $user, Item $item): bool
    {
        return $this->view($user, $item);
    }
}
