<?php

namespace App\Http\Resources\Api;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            "title" => $this->title,
            "wysiwyg_content" => $this->wysiwyg_content,
            "author_id"=> $this->wysiwyg_content,
            "author_full_name" => Author::where('id', $this->author_id)->select("full_name")->first()->full_name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
        ];
    }
}
