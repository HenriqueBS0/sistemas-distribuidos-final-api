<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Projeto $projeto)
    {
        if (Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $projeto->tarefas;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Projeto $projeto)
    {
        if (Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'titulo'     => [
                'required', 
                'string', 
                'max:75', 
                Rule::unique('tarefas')->where('projeto_id', $projeto->id)
            ],
            'descricao'  => ['required', 'string'],
            'estado'     => ['in:criada,iniciada,concluida'],
        ]);

        $data['projeto_id'] = $projeto->id;

        return Tarefa::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto, Tarefa $tarefa)
    {
        if (Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $tarefa;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projeto $projeto, Tarefa $tarefa)
    {
        if (Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'titulo'     => [
                'required', 
                'string', 
                'max:75', 
                Rule::unique('tarefas')->where('projeto_id', $projeto->id)->ignore($tarefa->id)
            ],
            'descricao'  => ['required', 'string'],
            'estado'     => ['in:criada,iniciada,concluida'],
        ]);

        $tarefa->update($data);

        return $tarefa;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto, Tarefa $tarefa)
    {
        if (Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $tarefa->delete();

        response()->noContent();
    }
}
