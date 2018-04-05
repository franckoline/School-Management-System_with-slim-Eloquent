<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateUserTable extends BaseMigration
{

    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('users_id')->unique();
            $table->string('username')-> unique();
            $table->string('firstname');
            $table->string('email')->unique();
            $table->string('token');
            $table->string('password');
            $table->timestamps();

        });
    }
    
    public function down()
    {
        //
        $this->schema->dropIfExists('users');
    }

}
