<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameToNullableInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
//            $table->enum('gender',['men','women',''])->change();
            $table->string('phone_number')->nullable()->change();//We can also add the "landing number" in the future
            $table->boolean('is_available')->nullable()->change();//We can also add the "birthday date" in the future
            $table->string('national_code',10)->nullable()->change();
            $table->string('card_number',16)->nullable()->change();//We can also add the "account number" and "night number" in the future
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
//            $table->enum('gender',['men','women'])->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();//We can also add the "landing number" in the future
            $table->boolean('is_available')->nullable(false)->change();//We can also add the "birthday date" in the future
            $table->string('national_code',10)->nullable(false)->change();
            $table->string('card_number',16)->nullable(false)->change();//We can also add the "account number" and "night number" in the future
        });
    }
}
