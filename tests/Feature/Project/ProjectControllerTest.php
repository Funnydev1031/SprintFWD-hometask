<?php

namespace Tests\Feature\Project;

use App\Models\Member;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $baseURL = "/api/projects/";


    public function test_project_cannot_be_created_without_required_fields():void
    {
        $response = $this->postJson($this->baseURL, []);

        $response
            ->assertStatus(422)
            ->assertInvalid(["name"]);
    }


    public function test_project_can_be_created(): void
    {
        $newProjectData = [
            "name"=> "project1",
        ];

        $response = $this->postJson($this->baseURL, $newProjectData);

        $response
            ->assertCreated()
            ->assertJson([
                "data" =>[
                    "name"=> "project1"
                ]
            ]);
    }


    public function test_project_can_be_updated(): void
    {

        $project = Project::factory()->create();

        $updateData = [
            "name"=> "project_for_testing_edited"
        ];

        $response = $this->putJson($this->baseURL.$project->id, $updateData);

        $response
            ->assertStatus(200)
            ->assertJson([
                "data" =>[
                    "name"=> "project_for_testing_edited"
                ]
            ]);
    }


    public function test_project_can_be_deleted(): void
    {

        $project = Project::factory()->create();

        $response = $this->deleteJson($this->baseURL.$project->id);

        $response->assertStatus(200);

        $this->assertModelMissing($project);
    }


    public function test_project_show_is_working(): void
    {

        $project = Project::factory()->create();

        $response = $this->getJson($this->baseURL.$project->id);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                "data"=> [
                    "id"=> $project->id,
                    "name"=> $project->name,
                ],
            ]);
    }


    public function test_project_list_is_working(): void
    {

        $projects = Project::factory(3)->create();

        $response = $this->getJson($this->baseURL);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, "data")
            ->assertJsonFragment([
                "name" => $projects[0]->name
            ])
            ->assertJsonFragment([
                "name" => $projects[1]->name
            ])
            ->assertJsonFragment([
                "name" => $projects[2]->name
            ]);
    }


    public function test_project_members_list_is_working(): void
    {

        $project = Project::factory()->create();

        $members = Member::factory(10)->create();

        $project->members()->sync($members->pluck('id'));

        $response = $this->getJson($this->baseURL.$project->id."/members");

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


    public function test_can_add_member_to_project(): void
    {

        $project = Project::factory()->create();

        $member = Member::factory()->create();

        $response = $this->postJson($this->baseURL.$project->id."/members", [
            "member_id"=> $member->id,
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas("member_project",[
            "member_id"=> $member->id,
            "project_id"=> $project->id,
        ]);
    }


}
