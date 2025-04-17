<?php

namespace App\Http\DTOs;

use DateTime;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        #[WithoutValidation]
        public ?int $id,
        #[Max(255), StringType()]
        public string $name,
        #[Unique('users', 'email', ignore: new RouteParameterReference('user', 'id'))]
        public string $email,
        public ?string $avatar,
        #[WithoutValidation]
        public ?string $workos_id,
        #[WithoutValidation]
        public ?DateTime $created_at,
        #[WithoutValidation]
        public ?DateTime $updated_at,
        #[DataCollectionOf(RoleData::class)]
        public ?DataCollection $roles,
    ) {
        //
    }
}
