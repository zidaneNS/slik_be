<?php

namespace App\Http\Controllers;

use App\Models\Kredit;
use Illuminate\Http\Request;

class KreditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kredits = Kredit::all();
        return response($kredits);
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
    public function show(Kredit $kredit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kredit $kredit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kredit $kredit)
    {
        //
    }
}
