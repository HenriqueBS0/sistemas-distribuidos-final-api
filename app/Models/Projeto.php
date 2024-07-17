<?php

namespace App\Models;

use App\Models\Enums\TarefaEstado;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projeto extends Model
{
    use HasFactory;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'tarefas_criadas',
        'tarefas_iniciadas',
        'tarefas_concluidas',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'descricao', 'user_id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tarefas() : HasMany
    {
        return $this->hasMany(Tarefa::class);
    }

    protected function tarefasCriadas() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->tarefas()->where('estado', TarefaEstado::Criada)->count(),
        );
    }
    
    protected function tarefasIniciadas() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->tarefas()->where('estado', TarefaEstado::Iniciada)->count(),
        );
    }

    protected function tarefasConcluidas() : Attribute
    {
        return Attribute::make(
            get: fn () => $this->tarefas()->where('estado', TarefaEstado::Concluida)->count(),
        );
    }
}
