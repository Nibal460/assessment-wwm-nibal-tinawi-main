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
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Add a name column for the category
        $table->timestamps(); // Optional: add timestamps for created_at and updated_at
    });
}

public function down()
{
    Schema::dropIfExists('categories');
}

};
