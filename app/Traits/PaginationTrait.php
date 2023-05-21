<?php

namespace App\Traits;

trait PaginationTrait
{
    public function paginationInformation($request, $paginated, $default)
    {
        return [
            'meta' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'links' => [
                    'previous' => $this->previousPageUrl(),
                    'next' => $this->nextPageUrl(),
                ],
            ]
        ];
    }
}
