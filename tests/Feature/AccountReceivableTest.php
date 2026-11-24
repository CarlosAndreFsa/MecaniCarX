<?php

namespace Tests\Feature;

use App\Models\AccountReceivable;
use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AccountReceivableTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function employee_cannot_access_accounts_receivable(): void
    {
        $company = Company::factory()->create();
        $employee = User::factory()->for($company)->create([
            'role' => 'employee',
            'active' => true,
        ]);

        $this->actingAs($employee)
            ->get(route('accounts-receivable.index'))
            ->assertForbidden();
    }

    #[Test]
    public function admin_can_create_direct_account_with_installments(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $response = $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Serviço particular',
            'issue_date' => '2026-11-23',
            'total' => 300,
            'installments_count' => 3,
            'first_due_date' => '2026-11-23',
        ]);

        $account = AccountReceivable::first();

        $response->assertRedirect(route('accounts-receivable.show', $account));
        $this->assertDatabaseCount('receivable_installments', 3);
        $this->assertEquals('300.00', $account->total);
    }

    #[Test]
    public function immediate_payment_marks_account_as_paid(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Pagamento PIX',
            'issue_date' => '2026-11-23',
            'total' => 150,
            'installments_count' => 1,
            'first_due_date' => '2026-11-23',
            'immediate_payment' => 1,
            'payment_method' => 'pix',
        ]);

        $account = AccountReceivable::first();

        $this->assertSame('paid', $account->status);
        $this->assertDatabaseHas('receivable_installments', [
            'account_receivable_id' => $account->id,
            'status' => 'paid',
            'payment_method' => 'pix',
            'received_amount' => 150,
        ]);
    }
}
