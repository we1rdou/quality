<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // aluminio, vidrio, accesorio, instalación
            $table->text('descripcion')->nullable();
            $table->float('longitud_pieza')->nullable(); // metros, unidades, m²
            $table->float('precio_pieza')->nullable();
            $table->string('unidad')->nullable(); // metros, m², unidades
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
