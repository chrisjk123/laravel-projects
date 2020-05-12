<?php

namespace Chriscreates\Projects\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasUsers
{
    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(
            get_class(user_model()),
            'project_users',
            'user_id',
            'project_id'
        );
    }

    /**
     * Add a user to the current Project.
     *
     * @param  string|int|\Illuminate\Database\Eloquent\Model $user
     * @param  array                   $pivot_columns
     * @return self
     */
    public function addUser($user, array $pivot_columns = []) : self
    {
        return $this->addUsers([$user], $pivot_columns);
    }

    /**
     * Add one or multiple users to the current Project.
     *
     * @param  array                   $users
     * @param  array                   $pivot_columns
     * @return self
     */
    public function addUsers(array $users = [], array $pivot_columns = []) : self
    {
        $keyed = collect($users)
        ->mapWithKeys(function ($user) use ($pivot_columns) {
            return [
                is_a($user, user_model()) ? $user->id : $user => $pivot_columns,
            ];
        })->toArray();

        $this->users()->syncWithoutDetaching($keyed);

        $this->load('users');

        $this->refresh('users');

        return $this;
    }

    /**
     * Remove the given user from the current Project
     *
     * @param  string|int|\Illuminate\Database\Eloquent\Model $user
     * @return self
     */
    public function removeUser($user) : self
    {
        return $this->users()->detach(is_a($user, user_model()) ? $user->id : $user);
    }

    /**
     * Remove one or multiple users from the current Project
     *
     * @param  array                   $users
     * @return self
     */
    public function removeUsers(array $users = []) : self
    {
        $keyed = collect($users)
        ->map(function ($user) use ($user_model) {
            return is_a($user, user_model()) ? $user->id : $user;
        })->toArray();

        $this->users()->detach($keyed);

        $this->load('users');

        $this->refresh('users');

        return $this;
    }

    /**
     * Check if the given user is on the current Project
     *
     * @param  string|int|\Illuminate\Database\Eloquent\Model $user
     * @return bool
     */
    public function hasUser($user) : bool
    {
        return $this->users->contains('id', is_a($user, user_model()) ? $user->id : $user);
    }
}
