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
class RoleData extends Data
{
    public function __construct(
        #[Unique('roles', 'name', ignore: new RouteParameterReference('role', 'name'))]
        public string $name,
        #[WithoutValidation]
        #[Max(255), StringType()]
        public ?int $id,
        #[Max(255), StringType()]
        public ?string $guard_name,
        #[WithoutValidation]
        public ?DateTime $created_at,
        #[WithoutValidation]
        public ?DateTime $updated_at,
        #[WithoutValidation]
        #[DataCollectionOf(UserData::class)]
        public ?DataCollection $users,
    ) {
        //
    }
}
