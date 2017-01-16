<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class debugController extends Controller
{
    public function debug($foo)
    {
        dd($foo);
    }
}
