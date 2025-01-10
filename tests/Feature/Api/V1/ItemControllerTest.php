<?php

namespace Tests\Feature\Api\V1;

use App\Models\Category;
use App\Models\Company;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Company $company;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['user_id' => $this->user->id]);
        $this->category = Category::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);
    }

    public function test_can_list_items(): void
    {
        Item::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson('/api/v1/items');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'code', 'name', 'description', 'category',
                        'unit', 'quantity', 'unit_price', 'stock', 'is_active',
                        'created_at', 'updated_at'
                    ]
                ]
            ]);
    }

    public function test_can_create_item(): void
    {
        $itemData = [
            'code' => 'ITEM001',
            'name' => 'Test Item',
            'description' => 'Test Description',
            'category_id' => $this->category->id,
            'unit' => 'Pcs',
            'quantity' => 10,
            'unit_price' => 100.00,
            'stock' => 50,
            'is_active' => true
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/items', $itemData);

        $response->assertCreated()
            ->assertJson([
                'data' => [
                    'name' => $itemData['name'],
                    'code' => $itemData['code'],
                    'unit_price' => $itemData['unit_price']
                ]
            ]);

        $this->assertDatabaseHas('items', [
            'name' => $itemData['name'],
            'user_id' => $this->user->id,
            'company_id' => $this->company->id
        ]);
    }

    public function test_can_show_item(): void
    {
        $item = Item::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/items/{$item->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $item->id,
                    'name' => $item->name
                ]
            ]);
    }

    public function test_can_update_item(): void
    {
        $item = Item::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $updateData = [
            'code' => 'UPDATED001',
            'name' => 'Updated Name',
            'description' => 'Updated Description',
            'category_id' => $this->category->id,
            'unit' => 'Box',
            'quantity' => 20,
            'unit_price' => 150.00,
            'stock' => 75,
            'is_active' => false
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/v1/items/{$item->id}", $updateData);

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'name' => $updateData['name'],
                    'code' => $updateData['code'],
                    'unit_price' => $updateData['unit_price']
                ]
            ]);
    }

    public function test_can_delete_item(): void
    {
        $item = Item::factory()->create([
            'user_id' => $this->user->id,
            'company_id' => $this->company->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/v1/items/{$item->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    public function test_cannot_access_items_from_other_company(): void
    {
        $otherCompany = Company::factory()->create();
        $item = Item::factory()->create([
            'company_id' => $otherCompany->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("/api/v1/items/{$item->id}");

        $response->assertForbidden();
    }

    public function test_validates_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/v1/items', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'unit', 'quantity', 'unit_price', 'stock']);
    }
}
