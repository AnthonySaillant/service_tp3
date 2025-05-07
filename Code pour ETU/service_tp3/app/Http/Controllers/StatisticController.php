<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statistic;
use App\Http\Resources\StatisticResource;

class StatisticController extends Controller
{
    public function index()
    {
        try
        {
            return StatisticResource::collection(Statistic::all())->response()->setStatusCode(200);
        }
        catch(Exception $ex)
        {
            abort(SERVER_ERROR, 'Server error');
        }        
    }
}
