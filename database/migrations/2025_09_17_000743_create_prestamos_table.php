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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->bigIncrements('prestamo_id');
            $table->foreignId('libro_id')->constrained('libros', 'libro_id')->cascadeOnDelete();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
            $table->date('fecha_devolucion_real')->nullable();
            $table->enum('estado', ['pendiente', 'devuelto', 'atrasado'])->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
