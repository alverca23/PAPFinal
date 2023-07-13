<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Avaliacions;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class avaliacionController extends Controller
{
    public function getAvalicion()
    {
        // Obtém o ID do usuário logado
        $user_id = auth()->user()->id;

        // Busca os campos específicos da avaliação do usuário logado na base de dados
        $avaliacao = Avaliacions::where('id_user', $user_id)->latest()->select('IMC', 'Supino', 'Agachamento', 'Levantamento_Terra', 'Peso_meta')->first();

        return response()->json($avaliacao);
    }
    
}