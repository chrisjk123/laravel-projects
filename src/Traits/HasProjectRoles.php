<?php

namespace Chriscreates\Projects\Traits;

use Chriscreates\Projects\Models\Project;

trait HasProjectRoles
{
    /**
     * Check the role of the relation on the Project.
     *
     * @param  string  $role
     * @param  \Chriscreates\Projects\Models\Project  $project
     * @return bool
     */
    public function roleOnProject(string $role, Project $project) : bool
    {
        if ( ! $this->isOnProject($project)) {
            return false;
        }

        $project_with_pivot = $this->projects->firstWhere(
            $project->getKeyName(),
            $project->getKey()
        );

        return $role === $project_with_pivot->pivot->role;
    }
}
