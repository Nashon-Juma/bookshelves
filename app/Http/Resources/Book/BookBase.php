<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorBase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Book $resource
 */
class BookBase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                ...$this->resource->meta,
                'entity' => $this->resource->entity,
            ],
            'title' => $this->resource->title,
            'author' => AuthorBase::make($this->resource->authorMain),
        ];
    }
}
