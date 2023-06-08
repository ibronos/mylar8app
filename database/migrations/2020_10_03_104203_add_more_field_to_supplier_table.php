<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldToSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier', function (Blueprint $table) {
           $table->string('email')->nullable()->after('name');
           $table->string('contact_name')->nullable()->after('address');
           $table->string('bank_account_name')->nullable()->after('bank_name');
           $table->string('address')->nullable()->change();
           $table->string('telephone')->nullable()->change();
           $table->string('bank_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier', function (Blueprint $table) {
            //
        });
    }
}
