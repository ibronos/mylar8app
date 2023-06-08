<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('po_no');
            $table->integer('month');
            $table->foreignId('id_order')->constrained('order')->onDelete('cascade');
            $table->foreignId('id_style')->constrained('style')->onDelete('cascade');
            $table->string('description');
            $table->foreignId('id_supplier')->constrained('supplier')->onDelete('cascade');
            $table->foreignId('id_inventory')->constrained('inventory')->onDelete('cascade');
            $table->string('payment_terms');
            $table->string('status');
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
        Schema::dropIfExists('purchasing');
    }
}
