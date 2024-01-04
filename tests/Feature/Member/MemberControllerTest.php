<?php

namespace Tests\Feature\Member;

use App\Models\Member;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $baseURL = "/api/members/";


    public function test_member_cannot_be_created_without_required_fields():void
    {
        $response = $this->postJson($this->baseURL, []);

        $response
            ->assertStatus(422)
            ->assertInvalid(["first_name", "last_name", "team_id"]);
    }


    public function test_member_can_be_created_with_just_required_fields(): void
    {
        $team = Team::factory()->create();

        $newMemberData = [
            "team_id"=> $team->id,
            "first_name"=> "first_name_test",
            "last_name"=> "last_name_test",
        ];

        $response = $this->postJson($this->baseURL, $newMemberData);

        $response
            ->assertCreated()
            ->assertJson([
                "data" =>[
                    "team_id"=> $team->id,
                    "first_name"=> "first_name_test",
                    "last_name"=> "last_name_test",
                ]
            ]);
    }


    public function test_member_can_be_created_with_all_fields(): void
    {
        $team = Team::factory()->create();

        $newMemberData = [
            "team_id"=> $team->id,
            "first_name"=> "first_name_test",
            "last_name"=> "last_name_test",
            "city"=> "some_city",
            "state"=> "some_state",
            "country"=> "some_country",
        ];

        $response = $this->postJson($this->baseURL, $newMemberData);

        $response
            ->assertCreated()
            ->assertJson([
                "data" =>[
                    "team_id"=> $team->id,
                    "first_name"=> "first_name_test",
                    "last_name"=> "last_name_test",
                    "city"=> "some_city",
                    "state"=> "some_state",
                    "country"=> "some_country",
                ]
            ]);
    }


    public function test_member_can_be_updated_with_just_required_fields(): void
    {

        $member = Member::factory()->create();

        $updateData = [
            "first_name"=> "fn1",
            "last_name"=> "ln1",
        ];

        $response = $this->putJson($this->baseURL.$member->id, $updateData);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "first_name"=> "fn1",
                    "last_name"=> "ln1",
                ]
            ]);
    }


    public function test_member_can_be_updated_with_all_fields(): void
    {

        $member = Member::factory()->create();

        $updateData = [
            "first_name"=> "fn1",
            "last_name"=> "ln1",
            "city"=> "city1",
            "state"=> "state1",
            "country"=> "country1",
        ];

        $response = $this->putJson($this->baseURL.$member->id, $updateData);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "first_name"=> "fn1",
                    "last_name"=> "ln1",
                    "city"=> "city1",
                    "state"=> "state1",
                    "country"=> "country1",
                ]
            ]);
    }


    public function test_member_can_be_deleted(): void
    {

        $member = Member::factory()->create();

        $response = $this->deleteJson($this->baseURL.$member->id);

        $response->assertStatus(200);

        $this->assertModelMissing($member);
    }


    public function test_member_show_is_working(): void
    {

        $member = Member::factory()->create();

        $response = $this->getJson($this->baseURL.$member->id);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data"=> [
                    "id"=> $member->id,
                    "team_id"=> $member->team_id,
                    "first_name"=> $member->first_name,
                    "last_name"=> $member->last_name,
                    "city"=> $member->city,
                    "state"=> $member->state,
                    "country"=> $member->country,
                ],
            ]);
    }


    public function test_member_list_is_working(): void
    {

        $members = Member::factory(3)->create();

        $response = $this->getJson($this->baseURL);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "data")
            ->assertJsonFragment([
                "first_name" => $members[0]->first_name,
                "last_name" => $members[0]->last_name,
            ])
            ->assertJsonFragment([
                "first_name" => $members[1]->first_name,
                "last_name" => $members[1]->last_name,
            ])
            ->assertJsonFragment([
                "first_name" => $members[2]->first_name,
                "last_name" => $members[2]->last_name,
            ]);
    }


    public function test_member_team_can_be_updated(): void
    {

        $member = Member::factory()->create();

        $team = Team::factory()->create();

        $response = $this->patchJson($this->baseURL.$member->id."/team", [
            "team_id"=> $team->id,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas("members", [
            "id"=> $member->id,
            "team_id"=> $team->id,
        ]);
    }
}
