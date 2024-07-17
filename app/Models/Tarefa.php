<?php

namespace App\Models;

use App\Models\Enums\TarefaEstado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tarefa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'descricao', 'estado', 'projeto_id'];

    public function projeto() : BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TarefaEstado::class,
        ];
    }
}
