<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Http\Requests\Member\UpdateTeamMemberRequest;
use App\Http\Resources\Member\MemberResource;
use App\Services\MemberService;

class MemberController extends Controller
{

    public function __construct(private MemberService $memberService)
    {}


    public function index()
    {
        return MemberResource::collection($this->memberService->getAll());
    }


    public function create()
    {
        //
    }

    public function store(StoreMemberRequest $request)
    {
        $member = $this->memberService->store(
            teamId: $request->validated("team_id"),
            firstName: $request->validated("first_name"),
            lastName: $request->validated("last_name"),
            city: $request->validated("city"),
            state: $request->validated("state"),
            country: $request->validated("country"),
        );

        return MemberResource::make($member);
    }


    public function show(Member $member)
    {
        return MemberResource::make($member);
    }


    public function edit(Member $member)
    {
        //
    }


    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member = $this->memberService->update(
            member: $member,
            firstName: $request->validated("first_name"),
            lastName: $request->validated("last_name"),
            city: $request->validated("city"),
            state: $request->validated("state"),
            country: $request->validated("country"),
        );

        return MemberResource::make($member);
    }


    public function destroy(Member $member)
    {
        $this->memberService->destroy($member);

        return response()->json();
    }


    public function updateTeam(UpdateTeamMemberRequest $request, Member $member)
    {
        $this->memberService->updateTeam($member, $request->validated("team_id"));

        return response()->json();
    }
}
