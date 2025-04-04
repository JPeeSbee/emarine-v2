<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Reset cached roles and permissions
         app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'Certificate Issuance']);
         Permission::create(['name' => 'Posted Certificate']);
         Permission::create(['name' => 'Certificate Summary']);
         Permission::create(['name' => 'User']);
         Permission::create(['name' => 'Role']);
         Permission::create(['name' => 'Agent']);
         Permission::create(['name' => 'Location']);
         Permission::create(['name' => 'Coverage']);
         Permission::create(['name' => 'Policy']);
         Permission::create(['name' => 'System Settings']);
 
         // create roles and assign existing permissions
         $encoder = Role::create(['name' => 'Encoder']);
         $encoder->givePermissionTo('Certificate Issuance');
         $encoder->givePermissionTo('Posted Certificate');
         $encoder->givePermissionTo('Certificate Summary');
 
         $admin = Role::create(['name' => 'Admin']);
         $admin->givePermissionTo('User');
         $admin->givePermissionTo('Role');
         $admin->givePermissionTo('Agent');
         $admin->givePermissionTo('Location');
         $admin->givePermissionTo('Coverage');
         $admin->givePermissionTo('Policy');
         $admin->givePermissionTo('System Settings');
 
         $superAdmin = Role::create(['name' => 'Super-Admin']);
         // gets all permissions via Gate::before rule; see AuthServiceProvider
 
         // create demo users
         $underwriting = \App\Models\User::factory()->create([
             'name' => 'Marine Underwriting',
             'email' => 'underwriting@maagap.com',
         ]);
         $underwriting->assignRole($encoder);
 
         $adminUser = \App\Models\User::factory()->create([
             'name' => 'Marine Admin',
             'email' => 'admin@maagap.com',
         ]);
         $adminUser->assignRole($admin);
 
         $superUser = \App\Models\User::factory()->create([
             'name' => 'Example Super-Admin User',
             'email' => 'superadmin@maagap.com',
         ]);
         $superUser->assignRole($superAdmin);
    }
}
