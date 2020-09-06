<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use League\Fractal\Manager;

class HealthController extends Controller
{

    public function health()
    {
        return response()->json([], 200);
    }

}
