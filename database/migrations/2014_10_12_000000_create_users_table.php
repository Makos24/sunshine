<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('student_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('other_name')->nullable();
            $table->integer('gender')->nullable();
            $table->date('dob')->nullable();
            $table->text('religion')->nullable();
            $table->string('email')->nullable();
            $table->text('phone_number')->nullable();
            $table->text('dad_number')->nullable();
            $table->text('mum_number')->nullable();
            $table->date('reg_date')->nullable();
            $table->integer('entry_year')->nullable();
            $table->integer('leave_year')->nullable();
            $table->string('address')->nullable();
            $table->integer('level')->nullable();
            $table->string('class')->nullable();
            $table->string('image')->nullable();
			$table->string('password');
            $table->boolean('active');
            $table->boolean('is_admin');
			$table->boolean('is_staff');
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
        Schema::drop('users');
    }
}
