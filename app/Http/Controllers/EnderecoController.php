<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnderecoController extends Controller
{
    public function index(Request $request)
    {

        $cep = $request->input('cep');
        
        if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
            return response()->json(['error' => 'CEP inválido'], 400);
        }

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        
        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao buscar o CEP'], 500);
        }

        return $response->json();

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'cep' => 'required|string|max:255',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'ibge' => 'required|string|max:255',

        ]);

        $endereco = Endereco::create($validated);

        return response()->json([
            'success' => true,
            'data' => $endereco,
            'message' => 'Endereço criado com sucesso!'
        ], 201);
    }
    


    public function show($cep)
{
    if (!preg_match('/^\d{5}-?\d{3}$/', $cep)) {
        return response()->json(['error' => 'CEP inválido'], 400);
    }

    $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

    if ($response->failed()) {
        return response()->json(['error' => 'Erro ao buscar o CEP'], 500);
    }

    return response()->json($response->json());
}
     
    public function update(Request $request, $id)
    {
        $endereco = Endereco::find($id);

        if (!$endereco) {
            return response()->json([
                'success' => false,
                'message' => 'Endereço não encontrado!'
            ], 404);
        }

        $validated = $request->validate([
            'cep' => 'nullable|string|max:255',
            'rua' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:255',
            'uf' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:255',
            'ibge' => 'nullable|string|max:255',

        ]);

        $endereco->update($validated);

        return response()->json([
            'success' => true,
            'data' => $endereco,
            'message' => 'Endereço atualizado com sucesso!'
        ]);
    }

    
    public function destroy($id)
    {
        $endereco = Endereco::find($id);

        if (!$endereco) {
            return response()->json([
                'success' => false,
                'message' => 'Endereço não encontrado!'
            ], 404);
        }

        $endereco->delete();

        return response()->json([
            'success' => true,
            'message' => 'Endereço excluído com sucesso!'
        ]);
    }

    
}