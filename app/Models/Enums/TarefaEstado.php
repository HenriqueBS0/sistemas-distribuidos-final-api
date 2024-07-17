<?php

namespace App\Models\Enums;

enum TarefaEstado: String {
    case Criada = 'criada';
    case Iniciada = 'iniciada';
    case Concluida = 'concluida';
}