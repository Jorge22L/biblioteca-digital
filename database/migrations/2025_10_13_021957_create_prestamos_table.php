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
        if (!Schema::hasTable('prestamos')) {
            Schema::create('prestamos', function (Blueprint $table) {
                $table->bigIncrements('prestamo_id'); // o el nombre de PK que uses
                $table->unsignedBigInteger('usuario_id')->nullable();
                $table->unsignedBigInteger('libro_id')->nullable();
                $table->date('fecha_prestamo');
                $table->date('fecha_devolucion')->nullable();
                $table->enum('estado', ['activo', 'devuelto', 'vencido'])->default('activo');
                $table->timestamps();

                // FKs
                $table->foreign('usuario_id')
                    ->references('usuario_id')->on('usuarios') // ← referencia usuario_id
                    ->onDelete('set null');

                $table->foreign('libro_id')
                    ->references('libro_id')->on('libros') // ← referencia libro_id
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
