<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStyleComponentMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('style_component_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_style_component')->constrained('style_component')->onDelete('cascade');
            $table->string('name');
            $table->decimal('calculation', 9, 3);
            $table->decimal('usage', 9, 3);
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
        Schema::dropIfExists('style_component_material');
    }
}
