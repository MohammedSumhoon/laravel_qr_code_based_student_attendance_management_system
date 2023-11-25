<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=['faculty','student'];
        foreach($permissions as $value)
        {
            $permission=new Permission;
            $permission->name=$value;
            $permission->save();
        }
    }
}
