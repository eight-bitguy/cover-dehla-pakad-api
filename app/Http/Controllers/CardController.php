<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use League\Fractal\Manager;

class CardController extends Controller
{
    private $cardService;

    public function __construct(Manager $manager, CardService $cardService)
    {
        parent::__construct($manager);
        $this->cardService = $cardService;
    }

}
