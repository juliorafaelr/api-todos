<?php

namespace App\JsonApi\V1\Tasks;

use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class TaskRequest extends ResourceRequest
{

    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'text' => ['required', 'string'],
            'day' => ['required', 'string'],
            'done' => ['required', JsonApiRule::boolean()]
        ];
    }

}
