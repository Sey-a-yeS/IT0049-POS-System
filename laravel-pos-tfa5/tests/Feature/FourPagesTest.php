<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Database\Seeders\CounterpointSampleSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class FourPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_four_pages_render_with_navigation(): void
    {
        $this->seed(CounterpointSampleSeeder::class);

        foreach (['/' => 'Home', '/about' => 'About', '/customers' => 'Customer Accounts', '/users' => 'User Accounts'] as $path => $title) {
            $response = $this->get($path);

            $response->assertOk()->assertSee($title);

            foreach (['/', '/about', '/customers', '/users'] as $navigationPath) {
                $response->assertSee('href="'.url($navigationPath).'"', false);
            }
        }
    }

    public function test_migrations_create_the_tfa2_columns_and_unique_username(): void
    {
        $this->assertTrue(Schema::hasColumns('customers', ['id', 'full_name', 'email', 'phone', 'created_at']));
        $this->assertTrue(Schema::hasColumns('users', ['id', 'username', 'full_name', 'created_at']));

        User::create(['username' => 'unique_user', 'full_name' => 'First Person']);
        $this->expectException(QueryException::class);
        User::create(['username' => 'unique_user', 'full_name' => 'Second Person']);
    }

    public function test_seeder_is_repeatable_and_controller_views_receive_eloquent_records(): void
    {
        $this->seed(CounterpointSampleSeeder::class);
        $this->seed(CounterpointSampleSeeder::class);

        $this->assertSame(5, Customer::count());
        $this->assertSame(5, User::count());

        $this->get('/customers')
            ->assertOk()
            ->assertViewHas('customers', fn (Collection $customers): bool => $customers->count() === 5 && $customers->first() instanceof Customer)
            ->assertSee('Amara Santos')
            ->assertSee('Tala Mendoza');

        $this->get('/users')
            ->assertOk()
            ->assertViewHas('users', fn (Collection $users): bool => $users->count() === 5 && $users->first() instanceof User)
            ->assertSee('Avery Ramos')
            ->assertSee('Joaquin Valdez');
    }

    public function test_listing_pages_render_new_database_records_and_escape_values(): void
    {
        Customer::create(['full_name' => '<script>alert(1)</script>', 'email' => 'new@example.com', 'phone' => null]);
        User::create(['username' => 'newstaff', 'full_name' => 'New Staff Member']);

        $this->get('/customers')
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('new@example.com');

        $this->get('/users')->assertOk()->assertSee('newstaff')->assertSee('New Staff Member');
    }

    public function test_empty_tables_show_readable_messages(): void
    {
        $this->get('/customers')->assertOk()->assertSee('No customer accounts are available yet.');
        $this->get('/users')->assertOk()->assertSee('No user accounts are available yet.');
    }

    public function test_home_and_about_remain_independent_of_database_queries(): void
    {
        $originalConnection = config('database.default');

        try {
            config()->set('database.default', 'unconfigured-tfa6-test');

            $this->get('/')->assertOk();
            $this->get('/about')->assertOk();
        } finally {
            config()->set('database.default', $originalConnection);
        }
    }
}
