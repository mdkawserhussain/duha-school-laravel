<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',
            'view events',
            'create events',
            'edit events',
            'delete events',
            'view notices',
            'create notices',
            'edit notices',
            'delete notices',
            'view staff',
            'create staff',
            'edit staff',
            'delete staff',
            'view admission applications',
            'edit admission applications',
            'delete admission applications',
            'view career applications',
            'edit career applications',
            'delete career applications',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $admissionsOfficerRole = Role::firstOrCreate(['name' => 'admissions_officer']);

        // Assign permissions to roles
        // Admin gets all permissions
        $adminRole->givePermissionTo(Permission::all());

        // Editor can manage content
        $editorRole->givePermissionTo([
            'view pages', 'create pages', 'edit pages', 'delete pages',
            'view events', 'create events', 'edit events', 'delete events',
            'view notices', 'create notices', 'edit notices', 'delete notices',
            'view staff', 'create staff', 'edit staff', 'delete staff',
        ]);

        // Admissions Officer can manage applications
        $admissionsOfficerRole->givePermissionTo([
            'view admission applications', 'edit admission applications',
            'view career applications', 'edit career applications',
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@almaghribschool.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // Change this in production!
            ]
        );
        $admin->assignRole('admin');

        // Create editor user
        $editor = User::firstOrCreate(
            ['email' => 'editor@almaghribschool.com'],
            [
                'name' => 'Content Editor',
                'password' => Hash::make('password'), // Change this in production!
            ]
        );
        $editor->assignRole('editor');

        // Create admissions officer user
        $admissionsOfficer = User::firstOrCreate(
            ['email' => 'admissions@almaghribschool.com'],
            [
                'name' => 'Admissions Officer',
                'password' => Hash::make('password'), // Change this in production!
            ]
        );
        $admissionsOfficer->assignRole('admissions_officer');
    }
}

