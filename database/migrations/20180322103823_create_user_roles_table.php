<?php

use Illuminate\Database\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateUserRolesTable extends BaseMigration
{

    public function up()
    {
        //

        $this->schema->create('usersRoles', function (Blueprint $table) {
            $table->increments('id')-> unique();

            $table->unsignedInteger('users_id');
            $table->unsignedInteger('roles_id');

            $table->foreign('users_id')
                ->references('users_id')->on('users')
                ->onDelete('cascade');
            $table->foreign('roles_id')
                ->references('roles_id')->on('roles')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        //

        $this->schema->dropIfExists('usersRoles');
    }

}
