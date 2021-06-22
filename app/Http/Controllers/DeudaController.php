<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Deuda;

class DeudaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try{
            $deuda = new Deuda;
            $deuda -> cedula = Crypt::encryptString($request->input('cedula'));
            $deuda -> capital = Crypt::encryptString($request->input('capital'));
            $deuda -> intereses = Crypt::encryptString($request->input('intereses'));
            $deuda -> save();
        }catch (\Exception $e) {
            $response = [
                'message' => $e->getMessage()
            ];
            return $json ? response()->json($response, 500) : ['response' => $response, 'code' => 500];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cedula)
    {
        try{
            $deuda = Deuda::firstOrFail()->where('cedula',$cedula)->get();
            $deuda[0]->cedula = Crypt::decryptString($deuda[0]->cedula);
            $deuda[0]->capital = Crypt::decryptString($deuda[0]->capital);
            $deuda[0]->intereses = Crypt::decryptString($deuda[0]->intereses);
            return $deuda;
        }catch (\Exception $e) {
            $response = [
                'message' => $e->getMessage()
            ];
            return $response;
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
