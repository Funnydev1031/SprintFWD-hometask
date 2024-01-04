<?php
namespace App\Services;

use App\Models\Team;

class TeamService {

    public function getAll()
    {
        return Team::all();
    }


    public function store(string $name)
    {
        return Team::create([
            "name"=> $name
        ]);
    }


    public function update(Team $team, string $name)
    {
        return tap($team)->update([
            "name"=> $name
        ]);
    }


    public function destroy(Team $team)
    {
        return $team->delete();
    }


    public function getMembers(Team $team)
    {
        return $team->members()->get();
    }

}
