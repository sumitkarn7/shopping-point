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
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('cat_id')->nullable()->constrained('categories','id')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('sub_cat_id')->nullable()->constrained('categories','id')->nullOnDelete()->cascadeOnUpdate();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->double('price');
            $table->float('discount')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->foreignId('seller_id')->nullable()->constrained('users','id')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->nullable()->constrained('users','id')->nullOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
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
