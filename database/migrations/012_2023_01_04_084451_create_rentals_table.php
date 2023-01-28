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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('category');
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->string('village');
            $table->string('parish');
            $table->string('subcounty');
            $table->string('county');
            $table->string('district');
            $table->string('country')->default('Uganda');
            $table->bigInteger('price');
            $table->string('timeframe')->default('month');
            $table->bigInteger('size')->nullable();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('kitchens');
            $table->boolean('pets')->default(0);
            $table->boolean('parties')->default(0);
            $table->boolean('smoking')->default(0);
            $table->boolean('furnished')->default(0);
            $table->boolean('renovated')->default(0);
            $table->boolean('guard')->default(0);
            $table->boolean('vacant')->default(0);
            $table->boolean('promoted')->default(0);
            $table->dateTime('advert_maturity')->nullable();
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
        Schema::dropIfExists('rentals');
    }
};
