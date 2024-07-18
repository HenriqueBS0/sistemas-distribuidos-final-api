<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->projetos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => [
                'required', 
                'string', 
                'max:75', 
                Rule::unique('projetos')->where('user_id', $request->user()->id)
            ],
            'descricao' => ['required', 'string'],
        ]);

        $data['user_id'] = $request->user()->id;

        return Projeto::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        if(Auth::user()->id === $projeto->user_id) {
            return $projeto;
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projeto $projeto)
    {
        if($request->user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'titulo' => [
                'required', 
                'string', 
                'max:75', 
                Rule::unique('projetos')->where('user_id', $request->user()->id)->ignore($projeto->id, '_id')
            ],
            'descricao' => ['required', 'string']
        ]);

        $projeto->update($data);

        return $projeto;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {

        if(Auth::user()->id !== $projeto->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $projeto->delete();

        response()->noContent();
    }
}
