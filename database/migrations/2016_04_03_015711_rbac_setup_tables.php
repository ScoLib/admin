<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RbacSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create(
            config('entrust.roles_table'),
            function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='角色表'";
                $table->increments('id');

                $table->string('name')
                    ->unique()
                    ->comment('名称');

                $table->string('display_name')
                    ->comment('显示名');

                $table->string('description')
                    ->nullable()
                    ->comment('备注');

                $table->timestamps();
            }
        );

        // Create table for associating roles to users (Many-to-Many)
        Schema::create(
            config('entrust.role_user_table'),
            function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='角色与用户对应表'";
                $table->integer(config('entrust.user_foreign_key'))
                    ->unsigned()
                    ->comment('管理员ID');

                $table->integer(config('entrust.role_foreign_key'))
                    ->unsigned()
                    ->comment('角色ID');

                $table->primary([
                    config('entrust.user_foreign_key'),
                    config('entrust.role_foreign_key'),
                ]);
            }
        );

        // Create table for storing permissions
        Schema::create(
            config('entrust.permissions_table'),
            function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='权限表'";

                $table->increments('id')
                    ->comment('主键');

                $table->string('display_name', 200)
                    ->comment('显示名称');

                $table->string('name', 100)
                    ->comment('名称');

                $table->string('description')
                    ->nullable()
                    ->comment('描述');

                $table->timestamps();
            }
        );

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create(
            config('entrust.permission_role_table'),
            function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='权限与角色对应表'";
                $table->integer(config('entrust.permission_foreign_key'))
                    ->unsigned()
                    ->comment('权限ID');

                $table->integer(config('entrust.role_foreign_key'))
                    ->unsigned()
                    ->comment('角色ID');

                $table->primary([
                    config('entrust.permission_foreign_key'),
                    config('entrust.role_foreign_key'),
                ]);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop(config('entrust.permission_role_table'));
        Schema::drop(config('entrust.permissions_table'));
        Schema::drop(config('entrust.role_user_table'));
        Schema::drop(config('entrust.roles_table'));
    }
}
