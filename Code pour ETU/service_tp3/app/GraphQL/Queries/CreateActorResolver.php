<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use App\Models\Actor;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

final readonly class CreateActorResolver
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $user = Auth::user();

        if ($user->role->name != 'ADMIN') {
            throw new AuthorizationException('Seuls les administrateurs peuvent créer une critique.');
        }

        $input = $args;

        $filmIds = $input['films']['connect'] ?? [];
        unset($input['films']);

        if (!empty($input['birthdate'])) {
            $input['birthdate'] = $input['birthdate']->toDateString(); //faisait une erreur de translate si non
        }

        $actor = Actor::create($input);

        if (!empty($filmIds)) {
            $actor->films()->attach($filmIds);
        }

        return $actor->load('films');
    }
}
