<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
    public function paginationInformation($request,$paginated,$default)
    {
        return [
            'meta'=>[
                'total'=>$this->total(),
                'count'=>$this->count(),
                'per_page'=>$this->perPage(),
                'current_page'=>$this->currentPage(),
                'total_pages'=>$this->lastPage(),
                'links'=>[
                    'previous'=>$this->previousPageUrl(),
                    'next'=>$this->nextPageUrl()
                ]
            ]
        ];
    }
}