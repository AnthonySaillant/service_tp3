<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Statistic;
use App\Http\Resources\StatisticResource;

class StatisticResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'average_score' => $this->average_score,
            'nb_votes' => $this->nb_votes,
            'film_id' => $this->film_id,
        ];        
    }
}
