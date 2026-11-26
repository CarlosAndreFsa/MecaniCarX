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

    #[Test]
    public function admin_can_filter_and_group_accounts_by_customer(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create(['name' => 'Cliente Agrupado']);

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Conta agrupada',
            'issue_date' => '2026-11-23',
            'total' => 100,
            'installments_count' => 1,
            'first_due_date' => '2026-12-10',
        ]);

        $response = $this->actingAs($admin)->get(route('accounts-receivable.index', [
            'customer_id' => $customer->id,
            'group_by' => 'customer',
        ]));

        $response->assertOk();
        $response->assertSee('Cliente Agrupado');
        $response->assertSee('10/12/2026');
    }

    #[Test]
    public function admin_can_export_accounts_as_csv(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Conta CSV',
            'issue_date' => '2026-11-23',
            'total' => 90,
            'installments_count' => 1,
            'first_due_date' => '2026-12-01',
        ]);

        $this->actingAs($admin)
            ->get(route('accounts-receivable.export.csv'))
            ->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    #[Test]
    public function ungrouped_accounts_are_ordered_by_the_next_due_date_and_status_filters_work(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Recebida com vencimento posterior',
            'issue_date' => '2026-11-23',
            'total' => 100,
            'installments_count' => 1,
            'first_due_date' => '2026-12-10',
            'immediate_payment' => 1,
            'payment_method' => 'pix',
        ]);

        $paidAccount = AccountReceivable::firstOrFail();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Pendente com vencimento anterior',
            'issue_date' => '2026-11-23',
            'total' => 200,
            'installments_count' => 1,
            'first_due_date' => '2026-12-01',
        ]);

        $pendingAccount = AccountReceivable::latest('id')->firstOrFail();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Recebimento parcial',
            'issue_date' => '2026-11-23',
            'total' => 150,
            'installments_count' => 1,
            'first_due_date' => '2026-12-05',
        ]);
        $partialAccount = AccountReceivable::latest('id')->firstOrFail();

        $this->actingAs($admin)->post(route('accounts-receivable.installments.receive', $partialAccount->installments()->first()), [
            'received_amount' => 50,
            'payment_method' => 'cash',
        ]);

        $this->actingAs($admin)
            ->get(route('accounts-receivable.index'))
            ->assertOk()
            ->assertSee('Financeiro')
            ->assertSeeInOrder([
                '#' . $pendingAccount->id,
                '#' . $partialAccount->id,
                '#' . $paidAccount->id,
            ]);

        $this->actingAs($admin)
            ->get(route('accounts-receivable.index', ['status' => 'open']))
            ->assertOk()
            ->assertSee('#' . $pendingAccount->id)
            ->assertSee('#' . $partialAccount->id)
            ->assertDontSee('#' . $paidAccount->id);

        $this->actingAs($admin)
            ->get(route('accounts-receivable.index', ['status' => 'received']))
            ->assertOk()
            ->assertSee('#' . $partialAccount->id)
            ->assertSee('#' . $paidAccount->id)
            ->assertDontSee('#' . $pendingAccount->id);

        $this->actingAs($admin)
            ->get(route('accounts-receivable.index', ['status' => 'paid']))
            ->assertOk()
            ->assertSee('#' . $paidAccount->id)
            ->assertDontSee('#' . $pendingAccount->id);
    }

    #[Test]
    public function due_date_range_must_match_the_same_installment(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Parcelas fora da faixa',
            'issue_date' => '2026-11-23',
            'total' => 200,
            'installments_count' => 2,
            'first_due_date' => '2026-11-01',
        ]);

        $account = AccountReceivable::firstOrFail();

        $this->actingAs($admin)
            ->get(route('accounts-receivable.index', [
                'from' => '2026-11-15',
                'to' => '2026-11-30',
            ]))
            ->assertOk()
            ->assertDontSee('#' . $account->id);
    }

    #[Test]
    public function ungrouped_list_shows_all_accounts_without_pagination(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        for ($number = 1; $number <= 17; $number++) {
            $account = AccountReceivable::create([
                'company_id' => $company->id,
                'customer_id' => $customer->id,
                'description' => 'Conta de teste ' . $number,
                'issue_date' => '2026-11-23',
                'total' => 100,
                'status' => 'pending',
            ]);

            $account->installments()->create([
                'number' => 1,
                'due_date' => now()->addDays($number)->toDateString(),
                'amount' => 100,
            ]);
        }

        $response = $this->actingAs($admin)
            ->get(route('accounts-receivable.index', ['group_by' => '']));

        $response->assertOk();
        for ($number = 1; $number <= 17; $number++) {
            $response->assertSee('#' . $number);
        }
        $response->assertDontSee('pagination');
    }

    #[Test]
    public function ungrouped_list_shows_each_installment_in_due_date_order(): void
    {
        $company = Company::factory()->create();
        $admin = User::factory()->for($company)->create([
            'role' => 'admin',
            'active' => true,
        ]);
        $customer = Customer::factory()->for($company)->create();

        $this->actingAs($admin)->post(route('accounts-receivable.store'), [
            'customer_id' => $customer->id,
            'description' => 'Conta em três parcelas',
            'issue_date' => '2026-11-23',
            'total' => 300,
            'installments_count' => 3,
            'first_due_date' => '2026-11-26',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('accounts-receivable.index', ['group_by' => '']));

        $response->assertOk()
            ->assertSeeInOrder([
                '26/11/2026',
                '26/12/2026',
                '26/01/2027',
            ])
            ->assertSee('1/3')
            ->assertSee('2/3')
            ->assertSee('3/3');

        $this->assertSame(3, substr_count($response->getContent(), 'data-installment-row='));
    }
}
