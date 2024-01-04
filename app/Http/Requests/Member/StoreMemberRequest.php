<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "team_id"=> "required|numeric|exists:teams,id",
            "first_name"=> "required|string",
            "last_name"=> "required|string",
            "city"=> "nullable|string",
            "state"=> "nullable|string",
            "country"=> "nullable|string",
        ];
    }
}
