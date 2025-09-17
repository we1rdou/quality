<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Esta migración consolida todos los campos adicionales de la tabla users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo agregar campos si no existen (para evitar errores si ya están aplicadas)
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
                $table->string('address')->nullable()->after('phone');
                $table->string('province')->nullable()->after('address');
                $table->string('city')->nullable()->after('province');
            }

            if (! Schema::hasColumn('users', 'oauth_provider')) {
                $table->string('oauth_provider')->nullable()->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'client'])->default('client')->after('city');
            }

            if (! Schema::hasColumn('users', 'is_suspended')) {
                $table->boolean('is_suspended')->default(false)->after('role');
                $table->timestamp('suspended_until')->nullable()->after('is_suspended');
                $table->string('suspension_reason')->nullable()->after('suspended_until');
                $table->timestamp('last_login_at')->nullable()->after('suspension_reason');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminar campos en orden inverso
            $columns = [
                'last_login_at',
                'suspension_reason',
                'suspended_until',
                'is_suspended',
                'role',
                'oauth_provider',
                'city',
                'province',
                'address',
                'phone',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
