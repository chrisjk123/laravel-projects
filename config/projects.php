<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | You may define a specific user model that your application will
    | use for authentication. This will define the relationships between
    | the users and their projects, tasks that they author.
    |
    */

    'user_class' => Illuminate\Foundation\Auth\User::class,

    /*
    |--------------------------------------------------------------------------
    | Base Ownership Role Name
    |--------------------------------------------------------------------------
    |
    | This is the defining name of the base ownership role name. As default
    | it is set to 'owner'.
    |
    */

    'owner_role' => 'owner',
];
