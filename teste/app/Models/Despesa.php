<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesa extends Model
{
    use HasFactory;

    protected $table = 'despesas';
    protected $fillable = ['user_id', 'data', 'descricao', 'valor'];

    public function user()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
