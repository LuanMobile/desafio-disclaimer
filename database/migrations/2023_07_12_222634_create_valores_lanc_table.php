<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valores_lanc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lanc_id')->constrained('lancamentos')->onDelete('cascade');
            $table->string('descricao');
            $table->string('salario');
            $table->decimal('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valores_lanc');
    }
};
