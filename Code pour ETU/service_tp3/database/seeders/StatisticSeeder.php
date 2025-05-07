<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $json = file_get_contents(database_path() . '/seeders/data_source.json');
        $data = json_decode($json, true);
        
        foreach ($data['data'] as $movie) {
            $reviews = $movie['reviews'];
            $averageScore = $this->calculateWeightedAverage($reviews);
            $totalVotes = $this->sumVotes($reviews);

            DB::table('statistics')->insert([
                'film_id' => $movie['id'],
                'average_score' => $averageScore,
                'nb_votes' => $totalVotes,
            ]);
        }
    }

    private function calculateWeightedAverage(array $reviews): float
    {
        $weightedTotal = 0;
        $totalVotes = 0;

        foreach ($reviews as $review) {
            $weightedTotal += $review['score'] * $review['votes'];
            $totalVotes += $review['votes'];
        }

        if($totalVotes > 0){
            return round($weightedTotal / $totalVotes, 2);
        }
        return 0;
    }

    private function sumVotes(array $reviews): int
    {
        $totalVotes = 0;
    
        foreach ($reviews as $review) {
            $totalVotes += $review['votes'];
        }
    
        return $totalVotes;
    }
}
