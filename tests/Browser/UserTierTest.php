<?php

use App\Models\Order;
use App\Models\User;

it('shows the user tier correctly in the UI', function () {

    $this->user = User::factory()->create();

    $this->orders = Order::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'amount' => fake()->numberBetween(20, 100),
    ]);

    visit('/login')
        ->fill('email', $this->user->email)
        ->fill('password', 'password')
        ->press('Sign In')
        ->assertSee('Users Management')
        ->assertSee('Bronze')
        ->assertDontSee('Silver')
        ->assertDontSee('Gold')
        ->assertDontSee('Platinum')
        ->assertDontSee('Diamond');
});
