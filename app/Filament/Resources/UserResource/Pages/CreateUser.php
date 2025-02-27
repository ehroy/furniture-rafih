<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function beforeSave(): void
    {
        // Pastikan role ada sebelum diberikan ke user
        if (!empty($this->data['role'])) {
            $this->record->syncRoles([$this->data['role']]); // Menggunakan syncRoles agar tidak duplikat
        }
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
    
    protected function afterCreate(): void
    {
        if (!empty($this->record->role)) {
            $this->record->syncRoles([$this->record->role]); // Pastikan hanya satu role yang di-set
        }
    
        // Berikan permission otomatis sesuai role
        $this->record->givePermissionTo($this->record->getRoleNames()->flatMap(fn ($role) => Role::findByName($role)->permissions->pluck('name')));
    }
}
