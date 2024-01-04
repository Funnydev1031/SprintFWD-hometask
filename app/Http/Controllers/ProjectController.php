<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\AddMemberProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Member\MemberResource;
use App\Http\Resources\Project\ProjectResource;
use App\Services\ProjectService;

class ProjectController extends Controller
{

    public function __construct(private ProjectService $projectService)
    {}


    public function index()
    {
        return ProjectResource::collection($this->projectService->getAll());
    }


    public function create()
    {
        //
    }


    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->store($request->validated("name"));

        return ProjectResource::make($project);
    }


    public function show(Project $project)
    {
        return ProjectResource::make($project);
    }


    public function edit(Project $project)
    {
        //
    }


    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->projectService->update($project, $request->validated("name"));

        return ProjectResource::make($project);
    }


    public function destroy(Project $project)
    {
        $this->projectService->destroy($project);

        return response()->json();
    }


    public function members(Project $project)
    {
        return MemberResource::collection($this->projectService->getMembers($project));
    }


    public function addMember(AddMemberProjectRequest $request, Project $project)
    {
        $this->projectService->addMember($project, $request->validated("member_id"));

        return response()->noContent();
    }


}
