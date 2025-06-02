<?php

namespace App\Http\Controllers;

use App\Models\Slik;
use Illuminate\Http\Request;

class SlikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliks = Slik::all();
        return response($sliks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'form_id' => 'required',
            'category_id' => 'required'
        ]);

        $slik = Slik::create([
            'form_id' => $validatedFields['form_id'],
            'category_id' => $validatedFields['category_id']
        ]);

        return response($slik, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slik $slik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slik $slik)
    {
        $validatedFields = $request->validate([
            'form_id' => 'required',
            'category_id' => 'required'
        ]);

        $slik->update([
            'form_id' => $validatedFields['form_id'],
            'category_id' => $validatedFields['category_id']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slik $slik)
    {
        $slik->delete();

        return response(null, 204);
    }
}
