<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContasRequest;
use App\Models\Contas;
use Illuminate\Http\Request;

class ApiContasController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContasRequest $request)
    {
        $contas = Contas::create($request->all());

        return response()->json([
            'conta' => $contas->conta_id,
            'valor' => $contas->valor
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contas  $contas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $contas = Contas::where('conta_id',$id)->first();

        return response()->json([
            'conta' => $contas->conta_id,
            'valor' => $contas->valor
        ],201);
    }


}
