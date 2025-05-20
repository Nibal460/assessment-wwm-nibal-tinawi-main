<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        // Add the category_id column to the products table if not already added
        $table->unsignedBigInteger('category_id')->nullable();

        // Add the foreign key constraint
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        // Drop the foreign key and the category_id column if rolling back
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });
}

};
