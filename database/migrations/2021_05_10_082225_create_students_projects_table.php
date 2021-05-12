<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_projects', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('project_id');

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->primary(['student_id','project_id']);            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_projects');
    }
}
