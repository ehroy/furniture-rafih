<?php

namespace App\Filament\Resources\SocialMediaResource\Pages;

use App\Filament\Resources\SocialMediaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSocialMedia extends CreateRecord
{
    protected static string $resource = SocialMediaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(empty($data['icon']))
        {
            $data['icon'] = 'default';
        }

        return $data;
    }
}
