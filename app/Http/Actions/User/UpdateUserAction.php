<?php

namespace App\Http\Actions\User;

use App\Http\DTOs\UserData;
use App\Models\User;

class UpdateUserAction
{
    public function handle(UserData $data, User $user): void
    {
        $user->name = $data->name;
        $user->email = $data->email;
        $user->syncRoles(
            collect($data->roles)->pluck('name')->toArray()
        );
        $user->save();
    }
}
