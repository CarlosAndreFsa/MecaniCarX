<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Produto;
use Illuminate\Http\Response;
use PhpParser\Node\Expr\FuncCall;

class ProdutoController extends Controller
{
    // Vamos adicionar a lógica aqui
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'descricao' => 'required|string|max:255',
            'preco' => 'required|numeric',
            'estoque' => 'required|integer'

        ]);

        $produto = Produto::create($request->all());
        
        return response()->json($produto, 201);

    }
}