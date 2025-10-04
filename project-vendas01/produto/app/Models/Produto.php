<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model{
    protected $fillable = [
        'name', 'descricao', 'preco', 'estoque'
    ];




}