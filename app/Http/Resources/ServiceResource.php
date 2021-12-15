<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'status' => $this->status,
            'logo' => $this->logo,
            'rewards' => $this->rewards,
            'rating' => $this->rating != null ? $this->rating : 'not_rated',
            'ratingTranslated' => $this->setRating($this->rating),
            'hardware' => $this->hardware,
            'complexity' => intval($this->complexity),
            'lock' => $this->lock,
            'created_at' => $this->created_at,
            'guide' => $this->guide,
            'types' => $this->types,
            'questions' => $this->questions,
            'requirements' => $this->systemRequirement,
        ];
    }

    private function setRating($rating){
        if ($rating == 'promising'){
            return __('common.promising');
        }
        if ($rating == 'high'){
            return __('common.high');
        }
        if ($rating == 'not_rated' || $rating == null){
            return __('common.not_rated');
        }
    }
}
