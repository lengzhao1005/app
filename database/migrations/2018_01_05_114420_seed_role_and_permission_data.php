<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedRoleAndPermissionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app('cache')->forget('spatie.permission.cache');

        // 先创建权限
        \Spatie\Permission\Models\Permission::create(['name' => 'manage_contents']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage_users']);
        \Spatie\Permission\Models\Permission::create(['name' => 'edit_settings']);

        // 创建站长角色，并赋与权限
        $founder = \Spatie\Permission\Models\Role::create(['name' => 'Founder']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        // 创建管理员角色，并赋与权限
        $maintainer = \Spatie\Permission\Models\Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');
        // 清空所有数据表数据
        $tableNames = config('permission.table_names');
        \App\Models\Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        \App\Models\Model::reguard();
    }
}
