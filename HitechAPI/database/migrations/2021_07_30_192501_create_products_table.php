<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('ProductID');
            $table->string('ProductCode');
            $table->integer('CustomerID');
            $table->string('ContractNumber');
            $table->string('ProductName');
            $table->date('StartDate');
            $table->date('EndDate');
            $table->date('SendStartDate');
            $table->date('SendEndDate');
            $table->date('ManuDate');
            $table->string('ExternalForm');
            $table->float('pH');
            $table->string('AuthorizedComName');
            $table->string('AuthorizedComAddress');
            $table->integer('method423');
            $table->integer('method402');
            $table->integer('method403');
            $table->integer('method406');
            $table->integer('method404');
            $table->integer('method405');
            $table->tinyInteger('Active');
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
        Schema::dropIfExists('products');
    }
}
