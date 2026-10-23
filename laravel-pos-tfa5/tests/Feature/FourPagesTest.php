<?php

namespace Tests\Feature;

use Tests\TestCase;

class FourPagesTest extends TestCase
{
    public function test_all_four_named_pages_render_with_navigation(): void
    {
        foreach (['/' => 'Home', '/about' => 'About', '/customers' => 'Customer Accounts', '/users' => 'User Accounts'] as $path => $title) {
            $response = $this->get($path);

            $response->assertOk()->assertSee($title);

            foreach (['/', '/about', '/customers', '/users'] as $navigationPath) {
                $response->assertSee('href="'.url($navigationPath).'"', false);
            }
        }
    }

    public function test_customer_and_user_records_are_supplied_by_controllers(): void
    {
        $this->get('/customers')
            ->assertOk()
            ->assertViewHas('customers', fn (array $customers): bool => count($customers) >= 5)
            ->assertSee('Amara Santos')
            ->assertSee('Tala Mendoza');

        $this->get('/users')
            ->assertOk()
            ->assertViewHas('users', fn (array $users): bool => count($users) >= 5)
            ->assertSee('Avery Ramos')
            ->assertSee('Joaquin Valdez');
    }

    public function test_required_pages_do_not_require_a_database_connection(): void
    {
        config()->set('database.default', 'unconfigured-tfa5-test');

        foreach (['/', '/about', '/customers', '/users'] as $path) {
            $this->get($path)->assertOk();
        }
    }
}
