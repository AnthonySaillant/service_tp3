<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\Auth;
use App\Models\Critic;
use App\Models\Statistic;
use Illuminate\Auth\Access\AuthorizationException;

final readonly class CreateCriticResolver
{
    /** @param  array{}  $args */
    public function __invoke($_, array $args)
    {
        $user = Auth::user();
        $input = $args['input'];

        $exists = Critic::where('user_id', $user->id)
                        ->where('film_id', $input['film_id'])
                        ->exists();

        if ($exists) {
            throw new AuthorizationException('Vous avez deja une critique pour ce film.');
        }

        $critic = Critic::create([
            'user_id' => $user->id,
            'film_id' => $input['film_id'],
            'score' => $input['score'],
            'comment' => $input['comment'],
        ]);

        $statistic = $critic->film->statistic;

        $newNbVotes = $statistic->nb_votes + 1;
        $newAverage = round((($statistic->average_score * $statistic->nb_votes) + $input['score']) / $newNbVotes, 2);

        $statistic->update([
            'nb_votes' => $newNbVotes,
            'average_score' => $newAverage,
        ]);

        return $critic;
    }
}
