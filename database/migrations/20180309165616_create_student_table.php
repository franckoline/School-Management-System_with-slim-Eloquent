<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateStudentTable extends BaseMigration
{

    public function up()
    {
        //

        $this->schema->create('students', function (Blueprint $table) {
            $table->increments('_id')->unique();
            $table->string('lastname')->unique();
            $table->string('middlename')->unique();
            $table->unsignedInteger('student_id');
            $table->string('firstname');
            $table->string('email');
            $table->unsignedInteger('role');
            $table->string('password');
            $table->string('token');
            $table->string('class');
            $table->string('class_arm');
            $table->string('last_login');
            $table->string('gender');
            $table->string('ethnicity');
            $table->binary('student_photo');
            $table->string('social_security');
            $table->dateTime('birthdate');
            $table->string('language');
            $table->string('physician_name');
            $table->string('physician_hospital');
            $table->string('estimated_grad_date');
            $table->string('alt_id');
            $table->string('physician_email');
            $table->string('physician_phone2');
            $table->string('student_address');
            $table->string('student_address_state');
            $table->string('sch_drop_off');
            $table->string('sch_pick_off');
            $table->string('bus_no');
            $table->string('prim_con_rel');
            $table->string('prim_con_state');
            $table->string('prim_con_f_name');
            $table->string('prim_con_o_name');
            $table->string('prim_con_phone1');
            $table->string('prim_con_phone2');
            $table->string('prim_con_email');
            $table->string('sec_con_rel');
            $table->string('sec_con_f_name');
            $table->string('sec_con_o_name');
            $table->string('sec_con_address');
            $table->string('sec_con_state');
            $table->string('sec_con_phone1');
            $table->string('sec_con_phone2');

            // $table->foreign('_id')
            //     ->references('admins_id')->on('admins')
            //     ->onDelete('cascade');
            // $table->foreign('firstname')
            //     ->references('firstname')->on('admins')
            //     ->onDelete('cascade');
            // $table->foreign('email')
            //     ->references('email')->on('admins')
            //     ->onDelete('cascade');
            // $table->foreign('role')
            //     ->references('role')->on('admins')
            //     ->onDelete('cascade');

            $table->timestamps();

        });
    }
    
    public function down()
    {
        //

        $this->schema->dropIfExists('students');
    }

}
