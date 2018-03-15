<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateParentTable extends BaseMigration
{

    public function up()
    {
        //

        $this->schema->create('parents', function (Blueprint $table) {
            $table->increments('parent_id', 25);
            $table->smallInteger('student_id', 15);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->smallInteger('role');
            $table->string('password');
            $table->text('token');
            $table->string('class');
            $table->string('class_arm');
            $table->date_Time('last_login');
            $table->string('gender');
            $table->string('ethnicity');
            $table->binary('student_photo');
            $table->string('social_security');
            $table->string('bus_no');
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
            $table->timestamps();
            $table->unique('last_name', 'middle_name');
            // primary key('student_id');
            // key 'name'('last_name', 'first_name', 'middel');
        });
    }
    
    public function down()
    {
        //
    }

}
