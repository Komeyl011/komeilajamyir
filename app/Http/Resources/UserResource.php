<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        
        return [
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'email_verified' => !is_null($this->email_verified_at),
            'phone_number' => $this->phone_number ?? '-',
            'phone_number_verified' => !is_null($this->phone_number_verified_at),
            'role' => $this->role,
            'ref_code' => $this->ref_code ?? 'not allowed',
        ];
    }
}
