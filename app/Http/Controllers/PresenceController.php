<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePresenceRequest;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::whereDate('created_at', Carbon::today())->latest()->get();

        return view('presences')->with('presences', $presences);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePresenceRequest $request)
    {
        Presence::create($request->all());

        return back()->with('success', 'Berhasil menambahkan kehadiran.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presence $presence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presence $presence)
    {
        $presence->delete();

        return back()->with('success', 'Berhasil menghapus kehadiran.');
    }
}
