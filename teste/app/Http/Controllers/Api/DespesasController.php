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
        return response()->json($this->despesasRepository->getPage(Auth::id(), array()));
    }
    public function store(DespesasFormRequest $request)
    {
        # code...
        $request->user_id = Auth::id();

        $despesaCriadaEvent = new EventsDespesaCriada(
            $request->data,
            $request->valor,
            $request->descricao,
            $request->user()
        );

        event($despesaCriadaEvent);

        return response()->json($this->despesasRepository->add($request), 201);
    }
    public function show(int $despesa)
    {
        $this->verifyDespesaPolicyItem($despesa, 'view');
        
        return response()->json($this->despesasRepository->getItem($despesa), 200);
    }
    public function update(Despesa $despesa, Request $request)
    {
        $this->verifyDespesaPolicyItem($despesa->id, 'update');

        return response()->json($this->despesasRepository->update($despesa, $request), 200);
    }
    public function destroy(int $despesa)
    {
        $this->verifyDespesaPolicyItem($despesa, 'delete');

        $this->despesasRepository->delete($despesa);
        return response()->noContent();
    }

    /**
     * Verifica a Policy escolhida de acordo com o item
     * @param int $itemId
     * @param string $policy - nome da policy desejada
     * @return void
     */
    private function verifyDespesaPolicyItem(int $itemId, string $policy)
    {
        $despesasModel = Despesa::find($itemId);
        $this->authorize($policy , $despesasModel);
    }
}
