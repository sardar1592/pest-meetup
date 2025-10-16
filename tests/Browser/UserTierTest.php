<?php

use App\Models\Order;
use App\Models\User;
use Laravel\Dusk\Browser;

beforeEach(function () {
    $this->user = User::factory()->create();

    Order::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'amount' => fake()->numberBetween(20, 100),
    ]);
});

it('shows Bronze tier correctly on Users Management page', function () {
    $this->browse(function (Browser $browser) {
        $browser->loginAs($this->user)
            ->visit('/users')
            ->pause(5000)
            ->assertSee('Users Management')
            ->assertSee('Bronze')
            ->assertDontSee('Silver')
            ->assertDontSee('Gold')
            ->assertDontSee('Platinum')
            ->assertDontSee('Diamond');
    });
});
