<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'roles-access',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-access',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            
            'files-access',
            'upload-file',
            
        ];
        
        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }

    }
}
