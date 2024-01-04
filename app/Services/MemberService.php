<?php
namespace App\Services;

use App\Models\Member;

class MemberService {

    public function getAll()
    {
        return Member::all();
    }


    public function store(int $teamId, string $firstName, string $lastName, ?string $city, ?string $state, ?string $country)
    {
        return Member::create([
            "team_id"=> $teamId,
            "first_name"=> $firstName,
            "last_name"=> $lastName,
            "city"=> $city,
            "state"=> $state,
            "country"=> $country,
        ]);
    }


    public function update(Member $member, string $firstName, string $lastName, ?string $city, ?string $state, ?string $country)
    {
        return tap($member)->update([
            "first_name"=> $firstName,
            "last_name"=> $lastName,
            "city"=> $city,
            "state"=> $state,
            "country"=> $country,
        ]);
    }


    public function destroy(Member $member)
    {
        return $member->delete();
    }


    public function updateTeam(Member $member, int $teamId)
    {
        return $member->update([
            "team_id"=> $teamId
        ]);
    }


}
