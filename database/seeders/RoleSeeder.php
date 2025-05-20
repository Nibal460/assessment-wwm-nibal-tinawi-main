<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Füge das richtige Role Model hinzu:
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'staff']);
}

}
