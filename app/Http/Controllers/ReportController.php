<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke()
    {
        $presences = Presence::orderBy('id', 'DESC')->get();

        return view('reports')->with('presences', $presences);
    }
}
