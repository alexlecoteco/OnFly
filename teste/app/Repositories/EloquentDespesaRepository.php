<?php

namespace App\Repositories;

use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentDespesaRepository implements DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesa
    {
        # code...
        return DB::transaction(function () use ($request) {
            $despesa = Despesa::create([
                'user_id' => $request->user_id,
                'data' => $request->data,
                'valor' => $request->valor,
                'descricao' => $request->descricao,
            ]);

            return $despesa;
        });
    }
    public function update(Despesa $despesa, Request $request): Despesa
    {
        $despesa->fill($request->all());
        $despesa->save();
        return $despesa;
    }
    public function getItem(int $id): Despesa
    {
        $despesasModel = Despesa::find($id);
        return $despesasModel;
    }
    public function getPage(int $userId, array $pageParams = array())
    {
        $despesas = Despesa::query();
        return $despesas->where('user_id', $userId)->paginate();
    }
    public function delete(int $id)
    {
        Despesa::destroy($id);
    }
}