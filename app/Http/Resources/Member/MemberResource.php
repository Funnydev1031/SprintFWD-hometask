<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "team_id"=> $this->team_id,
            "first_name"=> $this->first_name,
            "last_name"=> $this->last_name,
            "city"=> $this->city,
            "state"=> $this->state,
            "country"=> $this->country,
        ];
    }
}
