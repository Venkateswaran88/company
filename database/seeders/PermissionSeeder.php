<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminId = DB::table('permissions')->insertGetId([
            'name' => 'admin',
            'description' => 'admin',
        ]);

        $companyId = DB::table('permissions')->insertGetId([
            'name' => 'company',
            'description' => 'company',
        ]);

        $productId = DB::table('permissions')->insertGetId([
            'name' => 'product',
            'description' => 'product',
        ]);

        DB::table('user_permissions')->insert([
            'user_id' => '1',
            'permission_id' => $adminId,
        ]);
        DB::table('user_permissions')->insert([
            'user_id' => '2',
            'permission_id' => $companyId,
        ]);
        DB::table('user_permissions')->insert([
            'user_id' => '2',
            'permission_id' => $productId,
        ]);
    }
}
