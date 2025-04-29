<?php

namespace App\Domain\User\Resources;

use App\Http\Resources\GetAllUserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAllUserResourceCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'total_pages' => $this->lastPage(),
            'data' => GetAllUserResource::collection($this->collection),
        ];
    }
}
