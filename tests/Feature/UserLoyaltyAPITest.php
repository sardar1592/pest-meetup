<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->orders = Order::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'amount' => fake()->numberBetween(20, 99),
    ]);
});

it('detects the loyalty tier correctly', function () {
    $response = $this->actingAs($this->user)
        ->get('/api/loyalty/' . $this->user->id);

    $response->assertOk()
        ->assertJson([
            'user_id' => $this->user->id,
            'loyalty_tier' => 'Bronze',
            'orders_total' => $this->orders->sum('amount'),
            'order_count' => $this->orders->count(),
        ]);
});

it('returns 404 for a non-existent user', function () {
    $lastUser = User::latest('id')->first();

    $response = $this->actingAs($this->user)
        ->get('/api/loyalty/' . ($lastUser->id + 1));

    $response->assertNotFound();
});

it('returns 401 (or 302 if redirected) for unauthenticated user', function () {
    $response = $this->get('/api/loyalty/' . $this->user->id);

    // Laravel redirects unauthenticated users (302) unless using Sanctum/Passport etc.
    $response->assertStatus(302);
});

it('prevents one user from accessing another user’s loyalty info', function () {
    $anotherUser = User::factory()->create();

    $response = $this->actingAs($anotherUser)
        ->get('/api/loyalty/' . $this->user->id);

    $response->assertForbidden();
});
