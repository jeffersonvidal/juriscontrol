<?php

namespace App\Http\Controllers;

use App\Models\ExternalOffice;
use App\Models\ExternalPetition;
use App\Http\Controllers\Controller;
use App\Models\TypePetition;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ExternalPetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalPetitions = ExternalPetition::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)
        ->orderBy('name', 'ASC')->get();
        
        $users = User::where('company_id', auth()->user()->company_id)
        ->orderBy('name', 'ASC')->get();
        
        $wallets = Wallet::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();
        
        $typePetitions = TypePetition::where('company_id', auth()->user()->company_id)
        ->orderBy('id', 'DESC')->get();

        return view('external_petitions.index', [
            'externalPetitions' => $externalPetitions,
            'externalOffices' => $externalOffices,
            'wallets' => $wallets,
            'users' => $users,
            'typePetitions' => $typePetitions,
        ]);
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
    public function show(ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalPetition $externalPetition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalPetition $externalPetition)
    {
        //
    }
}
