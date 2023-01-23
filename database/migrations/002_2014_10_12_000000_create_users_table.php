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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('contract_url')->nullable();
            $table->boolean('tel')->default(0);
            $table->bigInteger('wallet')->default(0);
            $table->boolean('subscribed')->default(0);
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->dateTime('subscription_maturity')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_photo_url')->nullable();
            $table->string('id_front_url')->nullable();
            $table->string('id_back_url')->nullable();
            $table->boolean('verified')->default(0);
            $table->tinyInteger('role_id')->default(3);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
