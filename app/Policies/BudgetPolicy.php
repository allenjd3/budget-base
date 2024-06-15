<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Budget $budget): bool
    {
        assert($budget->user instanceof User);

        return $budget->user->id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Budget $budget): bool
    {
        return $this->view($user, $budget);
    }

    public function delete(User $user, Budget $budget): bool
    {
        return $this->view($user, $budget);
    }

    public function restore(User $user, Budget $budget): bool
    {
        return $this->view($user, $budget);
    }

    public function forceDelete(User $user, Budget $budget): bool
    {
        return $this->view($user, $budget);
    }
}
