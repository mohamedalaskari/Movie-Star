<?php

namespace App\Http\Controllers;

use App\Trait\responsetrait as TraitResponsetrait;
use App\Trait\subscripetrait;
use Illuminate\Http\ResponseTrait;

abstract class Controller
{
    use TraitResponsetrait , subscripetrait;
}
