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
    public function __construct($resource, $response)
    {
        parent::__construct($resource);
        $this->response = $response;
    }
    public function toArray(Request $request): array
    {
        return array_merge($this->response,[
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email
            ]
        ]);
    }
}
