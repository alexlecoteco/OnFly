<?php

namespace App\Http\Controllers\Api;

use App\Events\DespesaCriada as EventsDespesaCriada;
use App\Http\Controllers\Controller;
use App\Http\Requests\DespesasFormRequest;
use App\Mail\DespesaCriada;
use App\Models\Despesa;
use App\Models\User;
use App\Repositories\DespesasRepository;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DespesasController extends Controller
{
    public function __construct(private DespesasRepository $despesasRepository)
    {
        
    }
    public function index(Request $request)
    {
        $despesas = Despesa::query();
        return $despesas->where('user_id', Auth::id())->paginate();
    }
    public function store(DespesasFormRequest $request)
    {
        # code...
        $request->user_id = Auth::id();

        $despesaCriadaEvent = new \App\Events\DespesaCriada(
            $request->data,
            $request->valor,
            $request->descricao,
            $request->user()
        );

        event($despesaCriadaEvent);

        return response()->json($this->despesasRepository->add($request), 201);
    }
    public function show(int $despesas)
    {
        # code...
        $despesasModel = Despesa::find($despesas);

        $this->authorize('view', $despesasModel);

        return $despesasModel;
    }
    public function update(Despesa $despesa, Request $request)
    {
        # code...
        $despesaModel = Despesa::find($despesa);

        $this->authorize('update', $despesaModel);

        $despesa->fill($request->all());
        $despesa->save();

        return $despesa;
    }
    public function destroy(int $despesa)
    {
        # code...
        $despesaModel = Despesa::find($despesa);

        $this->authorize('delete', $despesaModel);

        Despesa::destroy($despesa);
        return response()->noContent();
    }
}
