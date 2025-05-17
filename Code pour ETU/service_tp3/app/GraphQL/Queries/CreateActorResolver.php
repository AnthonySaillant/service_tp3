<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use App\Models\Actor;


final readonly class CreateActorResolver
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $input = $args;

        $filmIds = $input['films']['connect'] ?? [];
        unset($input['films']);

        if (!empty($input['birthdate'])) {
            $input['birthdate'] = $input['birthdate']->toDateString();
        }

        $actor = Actor::create($input);

        if (!empty($filmIds)) {
            $actor->films()->attach($filmIds);
        }

        return $actor->load('films');
    }
}
