<?php

namespace App\Http\Resources\Configuration;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "min_order_amount" => $this->min_order_amount,
            "shipping_charge" => $this->shipping_charge,
            "avoid_shipping_charge_for" => $this->avoid_shipping_charge_for,
        ];
    }
}
