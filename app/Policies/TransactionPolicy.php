<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Transaction $transaction): bool
    {
        $budget = $transaction->budget;
        assert($budget instanceof Budget);

        return $budget->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $this->view($user, $transaction);
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $this->view($user, $transaction);
    }

    public function restore(User $user, Transaction $transaction): bool
    {
        return $this->view($user, $transaction);
    }

    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return $this->view($user, $transaction);
    }
}
