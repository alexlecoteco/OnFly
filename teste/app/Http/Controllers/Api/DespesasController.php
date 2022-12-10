<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;
use App\Repositories\DespesasRepository;
use Illuminate\Http\Request;

class DespesasController extends Controller
{
    public function __construct(private DespesasRepository $despesasRepository)
    {
        
    }
    public function index(Request $request)
    {
        $despesas = Despesa::query();
        return $despesas->paginate();
    }
    public function store(DespesasFormRequest $request)
    {
        # code...
        $request->user_id = Auth::id();
        return response()->json($this->despesasRepository->add($request), 201);
    }
    public function show(int $despesas)
    {
        # code...
        $despesasModel = Despesa::find($despesas);
        return $despesasModel;
    }
    public function update(Despesa $despesa, Request $request)
    {
        # code...
        $despesa->fill($request->all());
        $despesa->save();

        return $despesa;
    }
    public function destroy(int $despesa)
    {
        # code...
        Despesa::destroy($despesa);
        return response()->noContent();
    }
}
