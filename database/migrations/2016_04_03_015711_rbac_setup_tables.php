<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RbacSetupTables extends Migration
{
    private $managerTable;
    private $managerForeignKey;

    public function __construct()
    {
        $guard                   = config('admin.guard');
        $provider                = config("auth.guards.{$guard}.provider");
        $managerModelName        = config("auth.providers.{$provider}.model");
        $managerModel            = new $managerModelName();
        $this->managerTable      = $managerModel->getTable();
        $this->managerForeignKey = $managerModel->getForeignKey();
    }

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for admin user
        if ($this->managerTable != 'users') {
            Schema::create($this->managerTable, function (Blueprint $table) {
                $table->engine = "InnoDB COMMENT='管理员表'";
                $table->increments('id');

                $table->string('name')
                    ->unique()
                    ->comment('名称');

                $table->string('email')
                    ->unique()
                    ->comment('邮箱');

                $table->string('password')
                    ->comment('密码');

                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
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
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='角色与用户对应表'";
            $table->integer($this->managerForeignKey)
                ->unsigned()
                ->comment('管理员ID');

            $table->integer('role_id')
                ->unsigned()
                ->comment('角色ID');

            $table->primary([$this->managerForeignKey, 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='权限（即菜单）表'";

            $table->increments('id')
                ->comment('主键');

            $table->integer('pid')
                ->comment('父ID');

            $table->string('icon', 100)
                ->comment('图标class')
                ->default('');

            $table->string('display_name', 200)
                ->comment('显示名称');

            $table->string('name', 100)
                ->comment('名称');

            $table->tinyInteger('is_menu')
                ->comment('是否作为菜单')
                ->default('1');

            $table->tinyInteger('sort')
                ->unsigned()
                ->comment('排序')
                ->default('0');

            $table->string('description')
                ->nullable()
                ->comment('描述');

            $table->timestamps();
            $table->index('pid');
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = "InnoDB COMMENT='权限与角色对应表'";
            $table->integer('permission_id')
                ->unsigned()
                ->comment('权限ID');

            $table->integer('role_id')
                ->unsigned()
                ->comment('角色ID');

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
        if ($this->managerTable != 'users') {
            Schema::drop($this->managerTable);
        }
    }
}
