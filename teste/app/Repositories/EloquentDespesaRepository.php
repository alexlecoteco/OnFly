<?php

namespace App\Repositories;

use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;
use Illuminate\Support\Facades\DB;

class EloquentDespesaRepository implements DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesa
    {
        # code...
        return DB::transaction(function () use ($request) {
            $despesa = Despesa::create([
                'user_id' => $request->user_id,
                'valor' => $request->valor,
                'descricao' => $request->descricao,
            ]);

            return $despesa;
        });
    }
}