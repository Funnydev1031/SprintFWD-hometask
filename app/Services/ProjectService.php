<?php
namespace App\Services;

use App\Models\Project;

class ProjectService {

    public function getAll()
    {
        return Project::all();
    }


    public function store(string $name)
    {
        return Project::create([
            "name"=> $name
        ]);
    }


    public function update(Project $project, string $name)
    {
        return tap($project)->update([
            "name"=> $name
        ]);
    }


    public function destroy(Project $project)
    {
        return $project->delete();
    }


    public function getMembers(Project $project)
    {
        return $project->members()->get();
    }


    public function addMember(Project $project, int $memberId)
    {
        return $project->members()->attach($memberId);
    }

}
