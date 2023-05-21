<?php

namespace App\Http\Resources;

use App\Traits\PaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    use PaginationTrait;

    public function __construct($collection, $response)
    {
        parent::__construct($collection);
        $this->response = $response;
    }
    public function toArray(Request $request): array
    {
        return array_merge($this->response,[
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                ];
            }),
        ]);
    }
}
