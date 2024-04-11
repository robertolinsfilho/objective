<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContasRequest;
use App\Models\Contas;
use App\Models\Transacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTransacoesController extends Controller
{

    const PIX = 'P';
    const CARTAO_CREDITO = 'C';
    const CARTAO_DEBITO = 'D';
    const VALOR_C = 0.05;
    const VALOR_D = 0.03;


    public function store(StoreContasRequest $request)
    {

        $validator = Validator::make($request->all(), [
            'conta_id' => 'required|integer',
            'valor' => 'required',
            'forma_pagamento' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'messagem' => 'Campos estao faltando ou incorretos'
            ], 404);
        }

        $conta = Contas::where('conta_id',$request->conta_id)->first();

        if($conta->valor > $request->valor){

            $valorSubtracao = $this->desconto($request->valor,$request->forma_pagamento);
            Contas::where('conta_id',$request->conta_id)->update(['valor' => $conta->valor - $valorSubtracao]);
            Transacoes::create($request->all());
            $valorFinal = number_format( $conta->valor - $valorSubtracao,2);

            return response()->json([
                'conta' => $request->conta_id,
                'valor' => $valorFinal,
            ], 201);

        }else{
            return response()->json([
                'Messagem' => 'Saldo Insuficiente',
            ], 404);
        }

    }


    public function desconto($valorSubtracao,$metodo) {

        switch ($metodo) {
            case self::PIX:
               return $valorSubtracao;

            case self::CARTAO_CREDITO:
                $subtracao = $valorSubtracao * self::VALOR_C;
                $valorSubtracao = $valorSubtracao - $subtracao;
                return $valorSubtracao;

            case self::CARTAO_DEBITO:
                $subtracao = $valorSubtracao * self::VALOR_D;
                $valorSubtracao = $valorSubtracao - $subtracao;
                return $valorSubtracao;
        }
    }



}
