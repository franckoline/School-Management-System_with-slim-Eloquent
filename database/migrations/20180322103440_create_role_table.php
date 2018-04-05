<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateRoleTable extends BaseMigration
{

    public function up()
    {
        //

        $this->schema->create('roles', function (Blueprint $table) {
            $table->increments('roles_id')->unique();
            $table->string('Description')->unique();

            $table->timestamps();
        });
    }
    
    public function down()
    {
        //

        $this->schema->dropIfExists('roles');
    }
}
