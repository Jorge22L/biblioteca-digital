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
        if (!Schema::hasTable('libros')) {
            Schema::create('libros', function (Blueprint $table) {
                $table->bigIncrements('libro_id');
                $table->string('titulo');
                $table->string('autor');
                $table->string('isbn')->unique();
                $table->year('anio_publicacion')->nullable();
                $table->string('editorial')->nullable();
                $table->unsignedInteger('cantidad_ejemplares')->default(0);
                $table->unsignedInteger('ejemplares_disponible')->default(0);
                $table->enum('estado', ['disponible', 'agotado', 'inactivo'])->default('disponible');
                $table->string('imagen_url')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
