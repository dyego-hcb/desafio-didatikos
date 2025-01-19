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
        Schema::create('produto', function (Blueprint $table) {
            $table->id('codProduto');
            $table->string('nomeProduto')->unique();
            $table->float('valorProduto');
            $table->unsignedBigInteger('marcaProduto');
            $table->float('estoque');
            $table->unsignedBigInteger('cidade');
            $table->timestamps();

            $table->foreign('marcaProduto')->references('codMarca')->on('marca')->onDelete('cascade');
            $table->foreign('cidade')->references('codCidade')->on('cidade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto');
    }
};
