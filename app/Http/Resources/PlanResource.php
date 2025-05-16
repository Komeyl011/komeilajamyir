<?php

namespace App\Http\Resources;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'name' => $this->name,
            'price' => $this->price,
            'billing_interval' => (new Plan())->interval_translator[$this->billing_interval],
            'features' => $this->features,
        ];
    }
}
