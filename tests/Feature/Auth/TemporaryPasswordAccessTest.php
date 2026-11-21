<?php

namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class TemporaryPasswordAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_email_link_opens_password_change_without_login_form(): void
    {
        $company = Company::factory()->create();
        $customer = Customer::factory()->for($company)->create();
        $user = User::factory()->for($company)->create([
            'customer_id' => $customer->id,
            'role' => 'client',
            'active' => true,
            'password_must_be_changed' => true,
        ]);
        $url = URL::temporarySignedRoute(
            'password.temporary-access',
            now()->addDay(),
            ['user' => $user->id]
        );

        $this->get($url)
            ->assertRedirect(route('password.change'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('password.change'))->assertOk();
    }

    public function test_signed_link_cannot_be_used_after_temporary_password_is_cleared(): void
    {
        $company = Company::factory()->create();
        $customer = Customer::factory()->for($company)->create();
        $user = User::factory()->for($company)->create([
            'customer_id' => $customer->id,
            'role' => 'client',
            'active' => true,
            'password_must_be_changed' => false,
        ]);
        $url = URL::temporarySignedRoute(
            'password.temporary-access',
            now()->addDay(),
            ['user' => $user->id]
        );

        $this->get($url)->assertForbidden();
        $this->assertGuest();
    }
}
