<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('material_window', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('window_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad')->default(1); // cantidad de piezas de material usadas en la ventana
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_window');
    }
};
