<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proforma_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->float('alto');
            $table->float('ancho');
            $table->string('color_aluminio');
            $table->string('color_vidrio');
            $table->string('tipo_vidrio')->nullable();
            $table->integer('cantidad')->default(1);
            $table->float('precio_unitario')->nullable();
            $table->float('precio_total')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('windows');
    }
};
