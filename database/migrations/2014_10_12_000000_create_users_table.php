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
            $table->integer('followers_count')->default(0);
            $table->integer('followings_count')->default(0);
            $table->string('username')->unique();
            $table->integer('unread_notif')->default(0);
            $table->string('bio')->default("");
            $table->string('image')->default("storage/default-avatar.png");
            $table->string('tempImage')->default("");
            $table->string('email')->unique();
            $table->boolean('email_confirm')->default(false);
            $table->string('password');
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
