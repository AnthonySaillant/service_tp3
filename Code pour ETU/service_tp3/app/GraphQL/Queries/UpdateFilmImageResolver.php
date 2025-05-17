<?php declare(strict_types=1);

namespace App\GraphQL\Queries;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use App\Models\Film;


final readonly class UpdateFilmImageResolver
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        $user = Auth::user();

        if ($user->role->name != 'ADMIN') {
            abort(403, 'Seuls les administrateurs peuvent modifier un film.');
        }

        $film = Film::findOrFail($args['id']);

        $film->image = $args['image'];
        $film->save();

        return $film;
    }
}
