<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdeaPolicy
{
    /**
     * Determine whether the user can view any models.
     *      * return bool

     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *      * return bool

     */
    public function view(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *      * return bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user  autenticado can update the model.
     */
    public function update(User $user, Idea $idea): bool
    {
                                            //return $user->id === $idea->user_id;
        return $idea->user()->is($user);   //user() método dentro del modelo Idea
    }

    /**
     * Determine whether the user can delete the model.
     * * return bool
     */
    public function delete(User $user, Idea $idea)
    {
        return $this->update($user , $idea);
    }

    /**
     * Determine whether the user can restore the model.
     *      * return bool

     */
    public function restore(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     * return bool
     */
    public function forceDelete(User $user, Idea $idea)
    {
        //
    }

    /**
     * Determine whether the user can update the like field.
     */
    public function updateLikes(User $user, Idea $idea): bool
    {
        return $idea->user()->isNot($user); //podré dar like si el user asociado a la idea -> $idea->user()
                                            // no es el que está autenticado  ->isNot($user)
    }
}
