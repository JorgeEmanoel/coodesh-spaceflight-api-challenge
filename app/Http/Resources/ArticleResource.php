<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'featured' => $this->featured,
            'title' => $this->title,
            'url' => $this->url,
            'imageUrl' => $this->imageUrl,
            'newsSite' => $this->newsSite,
            'summary' => $this->summary,
            'publishedAt' => $this->publishedAt,
            'updatedAt' => $this->updatedAt,
            'launches' => $this->launches ?? [],
            'events' => $this->events ?? [],
        ];
    }
}
