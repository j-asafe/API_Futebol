<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jogador extends Model
{
    protected $fillable = [
        'nome', 'idade', 'posicao', 'nacionalidade', 'time'
    ];

    protected $table = 'jogadores';
}
