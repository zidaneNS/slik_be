<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Ktp;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::with('ktp')->get();
        return response($forms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'nama' => 'required',
            'NIK' => 'required',
            'alamat' => 'required',
            'TTL' => 'required',
            'tanggal_pengajuan' => 'required',
            'kredit_id' => 'required'
        ]);

        $ktp = Ktp::create([
            'nama' => $validatedFields['nama'],
            'NIK' => $validatedFields['NIK'],
            'alamat' => $validatedFields['alamat'],
            'TTL' => $validatedFields['TTL']
        ]);

        $form = Form::create([
            'ktp_id' => $ktp->id,
            'kredit_id' => $validatedFields['kredit_id'],
            'tanggal_pengajuan' => $validatedFields['tanggal_pengajuan']
        ]);

        return response($form, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $validatedFields = $request->validate([
            'nama' => 'required',
            'kredit_id' => 'required',
            'tanggal_pengajuan' => 'required',
            'alamat' => 'required',
            'TTL' => 'required',
            'NIK' => 'required'
        ]);

        $ktp = $form->ktp;
        $ktp->update([
            'nama' => $validatedFields['nama'],
            'NIK' => $validatedFields['NIK'],
            'alamat' => $validatedFields['alamat'],
            'TTL' => $validatedFields['TTL']
        ]);

        $form->update([
            'kredit_id' => $validatedFields['kredit_id'],
            'tanggal_pengajuan' => $validatedFields['tanggal_pengajuan']
        ]);

        return response($form);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $ktp = $form->ktp;
        $ktp->delete();

        $form->delete();

        return response(null, 204);
    }
}
