<?php

function projects_config_published()
{
    return file_exists(config_path('projects.php'));
}

function user_model()
{
    $user_class = config('projects.user_class');
    $repository = (new Illuminate\Config\Repository);
    $repository->set('custom', require projects_base_path('/config/projects.php'));

    if ( ! $user_class) {
        $user_class = $repository->get('custom.user_class');
    }

    return new $user_class;
}

function projects_base_path(string $append = '') : string
{
    return \Illuminate\Support\Str::replaceLast('/src/Helpers', '', dirname(__FILE__)).$append;
}
