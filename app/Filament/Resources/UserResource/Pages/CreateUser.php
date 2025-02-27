<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected  function afterCreate(): void
    {
        $user = $this->record; // Mengambil user yang baru dibuat

        if ($user->roles->isEmpty()) {
            $defaultRole = Role::where('name', 'admin')->first(); // Role default
            if ($defaultRole) {
                $user->assignRole($defaultRole);
            }
        }
    }

}
