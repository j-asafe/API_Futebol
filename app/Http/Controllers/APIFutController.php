<?php

namespace App\Http\Controllers;

use App\Models\Jogador;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class APIFutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todos os jogadores
        $registros = Jogador::all();

        // Contando o número de jogador
        $contador = $registros->count();

        // Verificando se há jogador
        if ($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'jogadores encontrados com sucesso!',
                'data' => $registros,
                'total' => $contador
            ], 200); // Retorna HTTP 200 (OK) com os dados e a contagem
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum Jogador encontrado.',
            ], 404); // Retorna HTTP 404 (Not Found) se não houver jogador
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'idade' => 'required',
            'posicao' => 'required',
            'nacionalidade' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'jogador inválidos',
                'errors' => $validator->errors()
            ], 400); // Retorna HTTP 400 (Bad Request) se houver erro de validação
        }

        // Criando um jogador no banco de dados
        $jogador = Jogador::create($request->all());

        if ($jogador) {
            return response()->json([
                'success' => true,
                'message' => 'Jogador cadastrado com sucesso!',
                'data' => $jogador
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar jogador!'
            ], 500); // Retorna HTTP 500 (Internal Server Error) se o cadastro falhar
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscando um jogador pelo ID
        $jogador = Jogador::find($id);

        // Verificando se o jogador foi encontrado
        if ($jogador) {
            return response()->json([
                'success' => true,
                'message' => 'jogador localizado com sucesso!',
                'data' => $jogador
            ], 200); // Retorna HTTP 200 (OK) com os dados do jogador
        } else {
            return response()->json([
                'success' => false,
                'message' => 'jogador não localizado.',
            ], 404); // Retorna HTTP 404 (Not Found) se o jogador não for encontrado
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'idade' => 'required',
            'posicao' => 'required',
            'nacionalidade' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'jogador inválidos',
                'errors' => $validator->errors()
            ], 400); // Retorna HTTP 400 se houver erro de validação
        }

        // Encontrando um jogador no banco
        $jogadorBanco = Jogador::find($id);

        if (!$jogadorBanco) {
            return response()->json([
                'success' => false,
                'message' => 'jogador não encontrado'
            ], 404);
        }

        // Atualizando os dados
        $jogadorBanco->nome = $request->nome;
        $jogadorBanco->idade = $request->idade;
        $jogadorBanco->posicao = $request->posicao;
        $jogadorBanco->nacionalidade = $request->nacionalidade;
        $jogadorBanco->time = $request->time;

        // Salvando as alterações
        if ($jogadorBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'jogador atualizado com sucesso!',
                'data' => $jogadorBanco
            ], 200); // Retorna HTTP 200 se a atualização for bem-sucedida
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o jogador'
            ], 500); // Retorna HTTP 500 se houver erro ao salvar
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrando um jogador no banco
        $jogador = Jogador::find($id);

        if (!$jogador) {
            return response()->json([
                'success' => false,
                'message' => 'jogador não encontrado'
            ], 404); // Retorna HTTP 404 se o jogador não for encontrado
        }
     // Deletando um jogador
    if ($jogador->delete()){
        return response()->json([
            'success' => true,
            'message' => 'jogador deletado com sucesso'
        ],200); // Retorna HTTP 200 se a exclusão for bem-sucedida
    }

    return response()->json([
        'success' => false,
        'message' => 'Erro ao deletar um jogador'
    ], 500); // Retorna HTTP 500 se houver erro na exclusão
    }
}