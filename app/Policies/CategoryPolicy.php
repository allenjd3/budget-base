<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny (User $user): bool
    {
        return false;
    }

    public function view (User $user, Category $category): bool
    {
        $categoryUser = $category->user;
        assert($categoryUser instanceof User);

        return $categoryUser->id === $user->id;
    }

    public function create (User $user): bool
    {
        return true;
    }

    public function update (User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }

    public function delete (User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }

    public function restore (User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }

    public function forceDelete (User $user, Category $category): bool
    {
        return $this->view($user, $category);
    }
}
