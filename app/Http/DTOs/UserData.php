<?php

namespace App\Http\DTOs;

use DateTime;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        #[WithoutValidation]
        public Optional|int $id,
        #[Max(255), StringType()]
        public string $name,
        #[Unique('users', 'email', ignore: new RouteParameterReference('user', 'id'))]
        public string $email,
        public Optional|string $avatar,
        #[WithoutValidation]
        public ?string $workos_id,
        #[WithoutValidation]
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?DateTime $created_at,
        #[WithoutValidation]
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?DateTime $updated_at,
    ) {
        //
    }
}
