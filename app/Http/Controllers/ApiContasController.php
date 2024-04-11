<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContasRequest;
use App\Models\Contas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiContasController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreContasRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'conta_id' => 'required|integer',
            'valor' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messagem' => 'Campos estão faltando'
            ], 404);
        }
        $contas = $this->validarConta($request->conta_id);

        if($contas) {
            return response()->json([
                'messagem' => 'Conta ja existe'
            ], 404);
        }
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

       $contas = $this->validarConta($id);

        if($contas){
            $contas = Contas::where('conta_id',$id)->first();
        }else{
            return response()->json([
                'messagem' => 'Conta invalida'
            ], 404);
        }
        return response()->json([
            'conta' => $contas->conta_id,
            'valor' => $contas->valor
        ],201);
    }

    public function validarConta($id){

        if(Contas::where('conta_id',$id)->first()){
            return true;
        }else{
            return false;
        }

    }
}
