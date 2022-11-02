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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('company_id'); // 外部キー
                $table->string('product_name', 100);
                $table->integer('price');
                $table->integer('stock');
                $table->text('comment')->nullable(); // null許可
                $table->string('image_path')->nullable();
                $table->timestamps();
                // 外部キー制約
                $table->foreign('company_id')->refereneces('id')->on('companies')->onDelete('cascade');
            });
        }

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
