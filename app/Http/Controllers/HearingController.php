<?php

namespace App\Http\Controllers;

use App\Models\Hearing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HearingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hearings = Hearing::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        //Carrega a view
        return view('hearings.index', ['hearings' => $hearings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Hearing $hearing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hearing $hearing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hearing $hearing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hearing $hearing)
    {
        //
    }
}
