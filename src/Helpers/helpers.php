<?php

function projects_config_published()
{
    return file_exists(config_path('projects.php'));
}
