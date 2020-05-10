<?php

namespace Chriscreates\Projects\Traits;

use Chriscreates\Projects\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasProjects
{
    use HasProjectRoles;

    public function projects() : BelongsToMany
    {
        return $this->belongsToMany(get_class(config('projects.user_class')), 'project_users', 'user_id', 'project_id');
    }

    /**
     * Get count of the model's Project relations
     *
     * @return bool
     */
    public function hasProjects() : bool
    {
        return $this->projects->count() > 0;
    }

    /**
     * Determine if the given Project is owned by the model.
     *
     * @param  \Chriscreates\Projects\Models\Project  $project
     * @return bool
     */
    public function ownsProject(Project $project) : bool
    {
        return $this->roleOnProject(config('projects.owner_role'), $project);
    }

    /**
     * Determine if the given model is on a Project.
     *
     * @param  \Chriscreates\Projects\Models\Project  $project
     * @return bool
     */
    public function isOnProject(Project $project) : bool
    {
        if ($this->projects->isEmpty()) {
            return false;
        }

        return $this->projects->contains($project->getKeyName(), $project->id);
    }
}
