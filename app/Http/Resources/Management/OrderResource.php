<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "identifier" => $this->identifier,
            "total" => $this->total,
            "quantity" => $this->quantity,
            "payment_method_key" => $this->payment_method_key,
            "source" =>  $this->source,
            "store_id" => $this->refer,
            "donor_name" => $this->full_name,
            "donor_mobile" =>  $this->donor_mobile,
            "donor_email" =>  $this->donor_email,
            "status" =>   $this->status,
            "create_date" => $this->created_at,
        ];
    }
}