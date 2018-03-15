<?php

use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends BaseMigration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->text('token');
            $table->string('bio');
            $table->string('image');
            $table->string('moto');
            $table->string('address');
            $table->string('mission');
            $table->string('vision');
            $table->string('about');
            $table->string('phone');
            $table->string('search_term');

            $table->timestamps();
        });

        //add this line to make id auto increment from a specified value 
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('users');
    }
}
