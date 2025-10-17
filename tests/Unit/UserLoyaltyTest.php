<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('assigns None tier to new user', function () {
    $user = User::factory()->create();

    expect($user->loyaltyTier())->toBe('None');
});

it('assigns None tier when total orders between 0 and 100', function () {
    $user = User::factory()->create();

    Order::factory()->count(5)->create([
        'user_id' => $user->id,
        'amount' => function () {
            return fake()->numberBetween(0, 20);
        },
    ]);

    expect($user->loyaltyTier())->toBe('None');
});

it('assigns Bronze tier when total orders between 100 and 500', function () {
    $user = User::factory()->create();

    Order::factory()->count(5)->create([
        'user_id' => $user->id,
        'amount' => fake()->numberBetween(20, 100),
    ]);

    expect($user->loyaltyTier())->toBe('Bronze');
});

it('assigns Silver tier when total orders between 500 and 1000', function () {
    $user = User::factory()->create();

    Order::factory()->count(5)->create([
        'user_id' => $user->id,
        'amount' => fake()->numberBetween(100, 200),
    ]);

    expect($user->loyaltyTier())->toBe('Silver');
});

it('assigns Gold tier when total orders between 1000 and 5000', function () {
    $user = User::factory()->create();

    Order::factory()->count(5)->create([
        'user_id' => $user->id,
        'amount' => fake()->numberBetween(200, 1000),
    ]);

    expect($user->loyaltyTier())->toBe('Gold');
});

it('assigns Platinum tier when total orders up to 10000', function () {
    $user = User::factory()->create();

    Order::factory()->count(10)->create([
        'user_id' => $user->id,
        'amount' => fake()->numberBetween(500, 999),
    ]);

    expect($user->loyaltyTier())->toBe('Platinum');
});

it('assigns Diamond tier when total orders above 10000', function () {
    $user = User::factory()->create();

    Order::factory()->count(15)->create([
        'user_id' => $user->id,
        'amount' => fake()->numberBetween(1000, 10000),
    ]);

    expect($user->loyaltyTier())->toBe('Diamond');
});

it('assigns Platinum tier when total orders exactly 5000', function () {
    $user = User::factory()->create();

    Order::factory()->create([
        'user_id' => $user->id,
        'amount' => 5000,
    ]);

    expect($user->loyaltyTier())->toBe('Platinum');
});

it('assigns Diamond tier when total orders exactly 10000', function () {
    $user = User::factory()->create();

    Order::factory()->create([
        'user_id' => $user->id,
        'amount' => 10000,
    ]);

    expect($user->loyaltyTier())->toBe('Diamond');
});

it('assigns Diamond tier when total orders exactly 10001', function () {
    $user = User::factory()->create();

    Order::factory()->create([
        'user_id' => $user->id,
        'amount' => 10001,
    ]);

    expect($user->loyaltyTier())->toBe('Diamond');
});
