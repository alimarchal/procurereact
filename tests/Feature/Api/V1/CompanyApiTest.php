<?php

namespace Tests\Feature\Api\V1;

use App\Models\Company;
use App\Models\User;
use App\Models\Quotation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected string $apiEndpoint = '/api/v1/companies';

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
    }

    public function test_user_can_list_companies(): void
    {
        Company::factory(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)
            ->getJson($this->apiEndpoint);

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ]
            ]);
    }

    public function test_user_can_create_company(): void
    {
        $companyData = [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'vat_number' => $this->faker->numerify('##########'),
            'company_type' => 'customer',
            'language' => 'english',
            'vat_percentage' => 15.00,
            'company_logo' => UploadedFile::fake()->image('logo.jpg'),
            'company_stamp' => UploadedFile::fake()->image('stamp.jpg'),
        ];

        $response = $this->actingAs($this->user)
            ->postJson($this->apiEndpoint, $companyData);

        $response->assertCreated();

        $this->assertDatabaseHas('companies', [
            'name' => $companyData['name'],
            'email' => $companyData['email'],
        ]);
    }

    public function test_user_can_view_company(): void
    {
        $company = Company::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->getJson("{$this->apiEndpoint}/{$company->id}");

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $company->id,
                    'name' => $company->name,
                    'email' => $company->email,
                ]
            ]);
    }

    public function test_user_can_update_company(): void
    {
        $company = Company::factory()->create([
            'user_id' => $this->user->id
        ]);

        $updateData = [
            'name' => 'Updated Company Name',
            'email' => 'updated@company.com',
            'company_type' => 'customer',
            'language' => 'english',
            'vat_percentage' => 15.00,
        ];

        $response = $this->actingAs($this->user)
            ->putJson("{$this->apiEndpoint}/{$company->id}", $updateData);

        $response->assertOk();

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $updateData['name'],
            'email' => $updateData['email'],
        ]);
    }

    public function test_user_can_delete_company(): void
    {
        $company = Company::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("{$this->apiEndpoint}/{$company->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function test_unauthenticated_user_cannot_access_api(): void
    {
        $response = $this->getJson($this->apiEndpoint);
        $response->assertUnauthorized();
    }

    public function test_company_validation_fails_with_invalid_data(): void
    {
        $invalidData = [
            'email' => 'not-an-email',
            'company_type' => 'invalid-type',
        ];

        $response = $this->actingAs($this->user)
            ->postJson($this->apiEndpoint, $invalidData);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'company_type']);
    }

    public function test_cannot_delete_company_with_related_records(): void
    {
        $company = Company::factory()->create([
            'user_id' => $this->user->id
        ]);

        // Create a quotation for the company
        Quotation::create([
            'quotation_number' => 'QT-001',
            'company_id' => $company->id,
            'created_by' => $this->user->id,
            'quotation_date' => now(),
            'valid_until' => now()->addDays(30),
            'subtotal' => 1000,
            'vat_rate' => 15,
            'vat_amount' => 150,
            'total' => 1150,
            'discount' => 0,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson("{$this->apiEndpoint}/{$company->id}");

        $response->assertUnprocessable();
        $this->assertDatabaseHas('companies', ['id' => $company->id]);
    }
}
