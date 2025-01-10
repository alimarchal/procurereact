<?php

namespace Tests\Feature\Api\V1;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;
    private User $user;
    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['user_id' => $this->user->id]);
    }
    public function test_user_can_get_projects_list()
    {
        $customer = Customer::factory()->create([
            'company_id' => $this->company->id,
            'user_id' => $this->user->id
        ]);

        Project::factory(3)->create([
            'user_id' => $this->user->id,
            'customer_id' => $customer->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/projects');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'status',
                        'customer_id',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_user_can_create_project()
    {
        $customer = Customer::factory()->create();

        $projectData = [
            'customer_id' => $customer->id,
            'name' => 'Test Project',
            'description' => 'Test Description',
            'status' => true
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/projects', $projectData);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => 'Test Project',
                    'description' => 'Test Description',
                    'status' => true,
                    'customer_id' => $customer->id
                ]
            ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'user_id' => $this->user->id
        ]);
    }

    public function test_user_can_show_project()
    {
        $project = Project::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/projects/{$project->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $project->id,
                    'name' => $project->name
                ]
            ]);
    }

    public function test_user_can_update_project()
    {
        $project = Project::factory()->create([
            'user_id' => $this->user->id
        ]);

        $customer = Customer::factory()->create();

        $updateData = [
            'customer_id' => $customer->id,
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'status' => false
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v1/projects/{$project->id}", $updateData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => 'Updated Project',
                    'description' => 'Updated Description'
                ]
            ]);
    }

    public function test_user_can_delete_project()
    {
        $project = Project::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/projects/{$project->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_user_cannot_access_others_project()
    {
        $otherUser = User::factory()->create();
        $project = Project::factory()->create([
            'user_id' => $otherUser->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/projects/{$project->id}");

        $response->assertForbidden();
    }

    public function test_validation_errors_for_create_project()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/projects', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'customer_id']);
    }
}
