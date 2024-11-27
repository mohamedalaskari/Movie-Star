<?php

namespace App\Http\Controllers;

use App\Trait\responsetrait as TraitResponsetrait;
use Illuminate\Http\ResponseTrait;

abstract class Controller
{
    use TraitResponsetrait;
}
