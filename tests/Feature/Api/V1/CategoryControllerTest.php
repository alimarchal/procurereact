<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['user_id' => $this->user->id]);
        $this->user->company()->save($this->company);
    }

    public function test_can_list_categories(): void
    {
        Category::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/categories');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'status', 'created_at', 'updated_at']
                ]
            ]);
    }

    public function test_can_create_category(): void
    {
        $categoryData = [
            'name' => 'Test Category',
            'description' => 'Test Description',
            'status' => true
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/categories', $categoryData);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'status' => $categoryData['status']
                ]
            ]);

        $this->assertDatabaseHas('categories', [
            'name' => $categoryData['name'],
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);
    }

    public function test_can_show_category(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/categories/{$category->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]);
    }

    public function test_can_update_category(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'status' => false
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v1/categories/{$category->id}", $updateData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $updateData['name'],
                    'description' => $updateData['description'],
                    'status' => $updateData['status']
                ]
            ]);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/categories/{$category->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_access_categories_from_other_company(): void
    {
        $otherCompany = Company::factory()->create();
        $category = Category::factory()->create([
            'company_id' => $otherCompany->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/categories/{$category->id}");

        $response->assertForbidden();
    }
}
