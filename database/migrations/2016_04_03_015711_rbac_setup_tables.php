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
        // Create table for admin user
        if (config('admin.user_table') != 'users') {
            Schema::create(config('admin.user_table'), function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='管理员表'";
                $table->increments('id');
                $table->string('name')->unique()->comment('名称');
                $table->string('email')->nullable()->unique()->comment('邮箱');
                $table->string('password')->nullable()->comment('密码');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='角色表'";
            $table->increments('id');
            $table->string('name')->unique()->comment('名称');
            $table->string('display_name')->nullable()->comment('显示名');
            $table->string('description')->nullable()->comment('备注');
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='角色与用户对应表'";
            $table->integer(config('admin.user_foreign_key'))->unsigned()->comment('管理员ID');
            $table->integer('role_id')->unsigned()->comment('角色ID');

            /*$table->foreign('uid')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');*/

            $table->primary([config('admin.user_foreign_key'), 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='权限（即菜单）表'";
            $table->increments('id')->comment('主键');
            $table->integer('pid')->comment('父ID');
            $table->string('icon', 100)->comment('图标class');
            $table->string('display_name', 200)->comment('显示名称');
            $table->string('name', 100)->comment('名称');
            $table->tinyInteger('is_menu')->comment('是否作为菜单')->default('1');
            $table->tinyInteger('sort')->unsigned()->comment('排序');
            $table->string('description')->nullable()->comment('描述');
            $table->timestamps();
            $table->index('pid');
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='权限与角色对应表'";
            $table->integer('permission_id')->unsigned()->comment('权限ID');
            $table->integer('role_id')->unsigned()->comment('角色ID');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
        if (config('admin.user_table') != 'users') {
            Schema::drop(config('admin.user_table'));
        }
    }
}
