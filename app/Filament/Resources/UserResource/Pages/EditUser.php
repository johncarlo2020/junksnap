<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Events\VerifyUser;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Runs after the form fields are saved to the database.
        $id = $this->getRecord()->id;
        $verify = $this->getRecord()->verified;

        event(new VerifyUser($id,$verify));
    }

    

    
}
