<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateAdminTable extends BaseMigration
{

    public function up()
    {
        //

        $this->schema->create('admins', function (Blueprint $table) {
            $table->increments('admins_id')->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->integer('role');
            $table->string('token');
            $table->string('password');
            $table->timestamps();
   
        });
    }

    public function down()
    {
        //

        $this->schema->dropIfExists('admins');
    }

}
