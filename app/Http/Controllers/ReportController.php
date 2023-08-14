<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = $request->get('q', false);

        $presences = Presence::when($q, function ($query) use ($q) {
            $query->where('employee_name', 'LIKE', "%$q%");
        })->orderBy('id', 'DESC')->get();

        return view('reports')->with('presences', $presences);
    }
}
