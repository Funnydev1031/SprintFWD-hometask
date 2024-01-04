<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Http\Resources\Member\MemberResource;
use App\Http\Resources\Team\TeamResource;
use App\Services\TeamService;

class TeamController extends Controller
{

    public function __construct(private TeamService $teamService)
    {}

    public function index()
    {
        return TeamResource::collection($this->teamService->getAll());
    }


    public function create()
    {
        //
    }


    public function store(StoreTeamRequest $request)
    {
        $team = $this->teamService->store($request->validated("name"));

        return TeamResource::make($team);
    }


    public function show(Team $team)
    {
        return TeamResource::make($team);
    }


    public function edit(Team $team)
    {
        //
    }


    public function update(UpdateTeamRequest $request, Team $team)
    {
        $team = $this->teamService->update($team, $request->validated("name"));

        return TeamResource::make($team);
    }


    public function destroy(Team $team)
    {
        $this->teamService->destroy($team);

        return response()->json();
    }


    public function members(Team $team)
    {
        return MemberResource::collection($this->teamService->getMembers($team));
    }
}
