<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getEvents()
    {
        // Obtém o ID do usuário logado
        $user_id = auth()->user()->id;

        // Busca os eventos do usuário logado na base de dados
        $events = Calendar::where('id_user', $user_id)->get(['date', 'event']);

        return response()->json($events);
    }

    public function getDescriptions(Request $request)
    {
        $user_id = auth()->user()->id;
        $date = $request->input('date');

        // Busca a descrição do evento para o usuário logado e data especificada
        $event = Calendar::where('id_user', $user_id)
            ->where('date', $date)
            ->first(['event']);

        return response()->json($event);
    }




}