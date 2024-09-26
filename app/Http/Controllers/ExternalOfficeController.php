<?php

namespace App\Http\Controllers;

use App\Models\ExternalOffice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HelpersAdm;

class ExternalOfficeController extends Controller
{
    private $helperAdm;

    public function __construct(HelpersAdm $helpersAdm){
        $this->helperAdm = $helpersAdm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $externalOffices = ExternalOffice::where('company_id', auth()->user()->company_id)->get();

        return view('external_offices.index', ['externalOffices' => $externalOffices]);
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
    public function show(ExternalOffice $externalOffice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExternalOffice $externalOffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExternalOffice $externalOffice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExternalOffice $externalOffice)
    {
        //
    }
}
