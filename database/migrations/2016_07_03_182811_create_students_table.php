<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('dob')->nullable();
            $table->string('email')->nullable();
            $table->text('phone_number')->nullable();
            $table->integer('entry_year')->nullable();
            $table->integer('leave_year')->nullable();
            $table->string('address');
            $table->integer('level');
            $table->string('class');
            $table->string('image')->nullable();
            $table->integer('active');
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
        Schema::drop('students');
    }
}
