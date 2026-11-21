<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('password_must_be_changed')->default(false)->after('active');
        });

        DB::table('users')
            ->where('role', 'client')
            ->whereNotNull('customer_id')
            ->update(['password_must_be_changed' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password_must_be_changed');
        });
    }
};
