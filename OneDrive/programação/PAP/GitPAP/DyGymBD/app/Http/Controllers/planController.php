<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pt;
use App\Models\Image;
use App\Models\User;
use App\Models\Plan;
use APP\Models\Exercise;
use App\Models\Plan_exercise;

class planController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //buscar o plano pelo id do user
    //fazer split da string nas virgulas com a funcao explode(",")
    //fazer for na array de exercicios, buscar cada um e dar return de todos

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function CreatePlan(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'id_user' => 'required|string',
            'id_exer' => 'required|string'
        ]);

        try {

            $plan = new Plan();
            $plan->name = $request->name;
            $plan->start_date = $request->start_date;
            $plan->end_date = $request->end_date;
            $plan->exercicios = $request->exercicios;
            $plan->id_user = $request->id_user;
            $plan->id_exer = $request->id_exer;

            $plan->save();

            //return successful response
            return response()->json(['plan' => $plan, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!' . $e], 409);
        }

    }

    public function getExercisesForLoggedInUser()
    {
        $loggedInUserId = auth()->user()->id;
    
        $user = User::find($loggedInUserId);
    
        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
    
        $plan = $user->plan()->first();
    
        if (!$plan) {
            return response()->json(['message' => 'Plano de treino não encontrado'], 404);
        }
    
        $planExercises = $plan->planExercises;
    
        $exercises = [];
    
        foreach ($planExercises as $planExercise) {
            $exercise = $planExercise->exercise;
            $exercise->Reps = $planExercise->Reps;
            $exercise->Sets = $planExercise->Sets;
    
            $exercises[] = $exercise;
        }
    
        return response()->json(['exercises' => $exercises], 200);
    }
    








    //
}