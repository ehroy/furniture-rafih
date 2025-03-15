<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_linker","view_any_linker","create_linker","update_linker","restore_linker","restore_any_linker","replicate_linker","reorder_linker","delete_linker","delete_any_linker","force_delete_linker","force_delete_any_linker","view_post","view_any_post","create_post","update_post","restore_post","restore_any_post","replicate_post","reorder_post","delete_post","delete_any_post","force_delete_post","force_delete_any_post","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","force_delete_product","force_delete_any_product","view_social::media","view_any_social::media","create_social::media","update_social::media","restore_social::media","restore_any_social::media","replicate_social::media","reorder_social::media","delete_social::media","delete_any_social::media","force_delete_social::media","force_delete_any_social::media","view_sub::category","view_any_sub::category","create_sub::category","update_sub::category","restore_sub::category","restore_any_sub::category","replicate_sub::category","reorder_sub::category","delete_sub::category","delete_any_sub::category","force_delete_sub::category","force_delete_any_sub::category","view_testimonial","view_any_testimonial","create_testimonial","update_testimonial","restore_testimonial","restore_any_testimonial","replicate_testimonial","reorder_testimonial","force_delete_any_testimonial","delete_testimonial","delete_any_testimonial","force_delete_testimonial","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","force_delete_any_user","delete_user","delete_any_user","force_delete_user","page_SettingsPage","widget_StatsOverview"]},{"name":"admin","guard_name":"web","permissions":["view_role","view_category","view_any_category","create_category","update_category","restore_category","restore_any_category","replicate_category","reorder_category","delete_category","delete_any_category","force_delete_category","force_delete_any_category","view_linker","view_any_linker","create_linker","update_linker","restore_linker","restore_any_linker","replicate_linker","reorder_linker","delete_linker","delete_any_linker","force_delete_linker","force_delete_any_linker","view_post","view_any_post","create_post","update_post","restore_post","restore_any_post","replicate_post","reorder_post","delete_post","delete_any_post","force_delete_post","force_delete_any_post","view_product","view_any_product","create_product","update_product","restore_product","restore_any_product","replicate_product","reorder_product","delete_product","delete_any_product","force_delete_product","force_delete_any_product","view_social::media","view_any_social::media","create_social::media","update_social::media","restore_social::media","restore_any_social::media","replicate_social::media","reorder_social::media","delete_social::media","delete_any_social::media","force_delete_social::media","force_delete_any_social::media","view_sub::category","view_any_sub::category","create_sub::category","update_sub::category","restore_sub::category","restore_any_sub::category","replicate_sub::category","reorder_sub::category","delete_sub::category","delete_any_sub::category","force_delete_sub::category","force_delete_any_sub::category","view_testimonial","view_any_testimonial","create_testimonial","update_testimonial","restore_testimonial","restore_any_testimonial","replicate_testimonial","reorder_testimonial","force_delete_any_testimonial","delete_testimonial","delete_any_testimonial","force_delete_testimonial"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
