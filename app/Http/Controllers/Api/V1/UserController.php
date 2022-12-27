<?php

namespace App\Http\Controllers\Api\V1;

use App\JsonApi\V1\Users\UserQuery;
use App\JsonApi\V1\Users\UserSchema;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\JsonApi\V1\Users\UserRequest;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class UserController extends Controller
{

    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * Create a new resource.
     *
     * @param UserSchema $schema
     * @param UserRequest $request
     * @param UserQuery $query
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function store(UserSchema $schema, UserRequest $request, UserQuery $query): \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
    {
        $user = $schema
            ->repository()
            ->create()
            ->withRequest($query)
            ->store($request->validated());

        $token = $user->createToken(Str::random(10));

        return DataResponse::make($user)
            ->withMeta(
                [
                    'token_type' => 'Bearer',
                    'token' => $token->plainTextToken
                ]
            );
    }
}
