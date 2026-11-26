<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_receivable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_order_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('description');
            $table->date('issue_date');
            $table->decimal('total', 12, 2);
            $table->enum('status', ['pending', 'partially_paid', 'paid', 'canceled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('receivable_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_receivable_id')->constrained('accounts_receivable')->cascadeOnDelete();
            $table->unsignedInteger('number');
            $table->date('due_date');
            $table->decimal('amount', 12, 2);
            $table->decimal('received_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'canceled'])->default('pending');
            $table->enum('payment_method', ['cash', 'pix', 'card'])->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['account_receivable_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivable_installments');
        Schema::dropIfExists('accounts_receivable');
    }
};
