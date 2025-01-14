<?php

use App\Models\Business;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
    $this->business = Business::factory()->create(['user_id' => $this->user->id]);
});

test('can list businesses', function () {
    $response = $this->getJson('/api/v1/businesses');
    $response->assertStatus(200)
        ->assertJsonStructure(['data']);
});

test('can create business', function () {
    $businessData = [
        'name' => 'Test Business',
        'email' => 'test@example.com',
        'user_id' => $this->user->id,
    ];

    $response = $this->postJson('/api/v1/businesses', $businessData);
    $response->assertCreated()
        ->assertJsonFragment(['name' => 'Test Business']);
});

test('can show business', function () {
    $response = $this->getJson("/api/v1/businesses/{$this->business->id}");
    $response->assertOk()
        ->assertJsonFragment(['id' => $this->business->id]);
});

test('can update business', function () {
    $response = $this->putJson("/api/v1/businesses/{$this->business->id}", [
        'name' => 'Updated Name',
        'user_id' => $this->user->id
    ]);

    $response->assertOk()
        ->assertJsonFragment(['name' => 'Updated Name']);
});

test('can delete business', function () {
    $response = $this->deleteJson("/api/v1/businesses/{$this->business->id}");
    $response->assertNoContent();

    $this->assertSoftDeleted($this->business);
});
