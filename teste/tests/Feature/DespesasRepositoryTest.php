<?php

namespace Tests\Feature;

use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;
use App\Models\User;
use App\Repositories\DespesasRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class DespesasRepositoryTest extends TestCase
{

    use RefreshDatabase;

    function createNewUser(){
        $user = $this->app->make(User::class);
        $user->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    }

    function createNewDespesa(DespesasRepository $repository){
        $request = new DespesasFormRequest();
        $request->user_id = 1;
        $request->data = '2022-10-11';
        $request->valor = 17.500;
        $request->descricao = 'Descricao';

        $repository->add($request);
    }
    public function test_despesa_criada()
    {
        // Criando usuário para efetuar os testes
        $this->createNewUser();

        $repository = $this->app->make(DespesasRepository::class);
        $this->createNewDespesa($repository);

        $this->assertDatabaseHas('despesas', ['descricao' => 'Descricao']);
    }

    public function test_buscar_lista_despesas()
    {
        // Criando usuário para efetuar os testes
        $this->createNewUser();
        
        $repository = $this->app->make(DespesasRepository::class);
        $this->createNewDespesa($repository);

        $this->assertNotEmpty($repository->getPage(1));
    }

    public function test_buscar_despesa()
    {
        // Criando usuário para efetuar os testes
        $this->createNewUser();
        
        $repository = $this->app->make(DespesasRepository::class);
        $this->createNewDespesa($repository);

        $despesa = $repository->getItem(1);

        $this->assertNotEmpty($despesa);
    }

    public function test_atualizar_despesa()
    {
        // Criando usuário para efetuar os testes
        $this->createNewUser();
        
        $repository = $this->app->make(DespesasRepository::class);
        $this->createNewDespesa($repository);

        $despesasModel = Despesa::find(1);

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['descricao' => 'Nova descricao']);

        $repository->update($despesasModel, $request);

        $this->assertDatabaseHas('despesas', ['descricao' => 'Nova descricao']);
    }

    public function test_apagar_despesa()
    {
        // Criando usuário para efetuar os testes
        $this->createNewUser();
        
        $repository = $this->app->make(DespesasRepository::class);
        $this->createNewDespesa($repository);

        $repository->delete(1);

        $this->assertDatabaseEmpty('despesas');
    }
}
