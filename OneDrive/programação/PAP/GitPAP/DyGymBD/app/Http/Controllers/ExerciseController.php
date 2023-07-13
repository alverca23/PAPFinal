<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pt;
use App\Models\Image;
use App\Models\Exercise;
use Illuminate\Support\Facades\Storage;


class ExerciseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function CreateExercise(Request $request)
    {
        try {
            $exercise = new Exercise;

            if ($request->hasFile('ficheiro')) {
                $original_filename = $request->file('ficheiro')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = './images/exercicios/';
                $file = $original_filename; // Usar o nome original do arquivo
            
                if ($request->file('ficheiro')->move($destination_path, $file)) {
                    $exercise->Ficheiro = URL('/') . '/images/exercicios/' . $file;
                }
            }
            

            $exercise->Name = $request->input('Name');
            $exercise->Sets = 0;
            $exercise->Reps = 0;
            $exercise->Section = $request->input('Section');
            $exercise->save();

            return response()->json(['created' => $exercise], 200);
        } catch (\Exception $e) {
            // return error message
            return response()->json(['message' => 'Exercise Registration Failed! ' . $e->getMessage()], 409);
        }
    }

    public function updateExercicio(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        $this->validate($request, [
            'Sets' => 'nullable|numeric',
            'Reps' => 'nullable|String',
        ]);

        if ($request->has('Sets')) {
            $exercise->Sets = $request->input('Sets');
        } else {
            $exercise->Sets = $exercise->Sets;
        }
        if ($request->has('Reps')) {
            $exercise->Reps = $request->input('Reps');
        } else {
            $exercise->Reps = $exercise->Reps;
        }

        $exercise->save();

        return response()->json($exercise, 200);
    }
}