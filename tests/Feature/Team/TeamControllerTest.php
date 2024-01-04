<?php

namespace Tests\Feature\Team;

use App\Models\Member;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{

    use RefreshDatabase;

    private string $baseURL = "/api/teams/";


    public function test_team_cannot_be_created_without_required_fields():void
    {
        $response = $this->postJson($this->baseURL, []);

        $response
            ->assertStatus(422)
            ->assertInvalid(["name"]);
    }


    public function test_team_can_be_created(): void
    {
        $newTeamData = [
            "name"=> "team1",
        ];

        $response = $this->postJson($this->baseURL, $newTeamData);

        $response
            ->assertCreated()
            ->assertJson([
                "data" =>[
                    "name"=> "team1"
                ]
            ]);
    }


    public function test_team_can_be_updated(): void
    {

        $team = Team::factory()->create();

        $updateData = [
            "name"=> "team_for_testing_edited"
        ];

        $response = $this->putJson($this->baseURL.$team->id, $updateData);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "name"=> "team_for_testing_edited"
                ]
            ]);
    }


    public function test_team_can_be_deleted(): void
    {

        $team = Team::factory()->create();

        $response = $this->deleteJson($this->baseURL.$team->id);

        $response->assertStatus(200);

        $this->assertModelMissing($team);
    }


    public function test_team_show_is_working(): void
    {

        $team = Team::factory()->create();

        $response = $this->getJson($this->baseURL.$team->id);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data"=> [
                    "id"=> $team->id,
                    "name"=> $team->name,
                ],
            ]);
    }


    public function test_team_list_is_working(): void
    {

        $teams = Team::factory(3)->create();

        $response = $this->getJson($this->baseURL);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "data")
            ->assertJsonFragment([
                "name" => $teams[0]->name
            ])
            ->assertJsonFragment([
                "name" => $teams[1]->name
            ])
            ->assertJsonFragment([
                "name" => $teams[2]->name
            ]);
    }


    public function test_team_members_list_is_working(): void
    {

        $team = Team::factory()->create();

        $members =  Member::factory(10)->for($team)->create();

        $response = $this->getJson($this->baseURL.$team->id."/members");

        $response
            ->assertStatus(200)
            ->assertJsonCount(10, "data")
            ->assertJsonFragment([
                "id" => $members[0]->id,
                "first_name" => $members[0]->first_name,
            ])
            ->assertJsonFragment([
                "id" => $members[1]->id,
                "first_name" => $members[1]->first_name,
            ])
            ->assertJsonFragment([
                "id" => $members[2]->id,
                "first_name" => $members[2]->first_name,
            ]);
    }


}
