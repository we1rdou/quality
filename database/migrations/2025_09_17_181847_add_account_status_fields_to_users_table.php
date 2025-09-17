<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agregamos los campos que realmente necesitamos
            $table->boolean('is_suspended')->default(false)->after('role');
            $table->timestamp('suspended_until')->nullable()->after('is_suspended');
            $table->string('suspension_reason')->nullable()->after('suspended_until');
            $table->timestamp('last_login_at')->nullable()->after('suspension_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_suspended',
                'suspended_until',
                'suspension_reason',
                'last_login_at',
            ]);
        });
    }
};
