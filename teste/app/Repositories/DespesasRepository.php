<?php

namespace App\Repositories;

use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;
use Illuminate\Http\Request;

interface DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesa;
    public function getItem(int $id): Despesa;
    public function getPage(int $userId, array $pageParams);
    public function update(Despesa $despesa, Request $request): Despesa;
    public function delete(int $id);
}