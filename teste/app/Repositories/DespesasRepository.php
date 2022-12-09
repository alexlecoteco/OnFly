<?php

namespace App\Repositories;

use App\Http\Requests\DespesasFormRequest;
use App\Models\Despesa;

interface DespesasRepository
{
    public function add(DespesasFormRequest $request): Despesa;
}