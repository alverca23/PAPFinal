<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\UserFactory;


//import auth facades
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */


    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->birthday = 0;
            $user->height = 0;
            $user->weight = 0;
            $user->hobbies = 0;
            $user->peso_meta = 0;
            $user->supino = 0;
            $user->agachamento = 0;
            $user->levantamento = 0;
            $user->date = 0;
            $user->id_conta = null;
            $user->id_pts = null;
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $pt = Pt::inRandomOrder()->first();

            $user->id_pts = $pt->id;

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!' . $e], 409);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        return $this->respondWithToken($token);
    }

    /**
     * Get a info.
     *
     * @param  Request  $request
     * @return Response
     */

    public function update(Request $request)
    {


        $this->validate($request, [
            'birthday' => 'nullable|string',
            'hobbies' => 'nullable|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
        ]);
        try {
            $user = Auth::user();
            if ($request->has('birthday')) {
                $user->birthday = $request->input('birthday');
            } else {
                $user->birthday = $user->birthday;
            }
            if ($request->has('hobbies')) {
                $user->hobbies = $request->input('hobbies');
            } else {
                $user->hobbies = $user->hobbies;
            }
            if ($request->has('weight')) {
                $user->weight = $request->input('weight');
            } else {
                $user->weight = $user->weight;
            }
            if ($request->has('height')) {
                $user->height = $request->input('height');
            } else {
                $user->height = $user->height;
            }

            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return $e;
        }

    }

    public function infos(Request $request)
    {


        $this->validate($request, [
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
        ]);
        try {
            $user = Auth::user();
            if ($request->has('name')) {
                $user->name = $request->input('name');
            } else {
                $user->name = $user->name;
            }
            if ($request->has('email')) {
                $user->email = $request->input('email');
            } else {
                $user->email = $user->email;
            }
            if ($request->has('weight')) {
                $user->weight = $request->input('weight');
            } else {
                $user->weight = $user->weight;
            }
            if ($request->has('height')) {
                $user->height = $request->input('height');
            } else {
                $user->height = $user->height;
            }

            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return $e;
        }

    }


    public function objetiv(Request $request)
    {

        $this->validate($request, [
            'peso_meta' => 'nullable|numeric',
            'supino' => 'nullable|numeric',
            'agachamento' => 'nullable|numeric',
            'levantamento' => 'nullable|numeric',
            'date' => 'nullable|string',
        ]);
        try {
            $user = Auth::user();
            if ($request->has('peso_meta')) {
                $user->peso_meta = $request->input('peso_meta');
            } else {
                $user->peso_meta = $user->peso_meta;
            }
            if ($request->has('supino')) {
                $user->supino = $request->input('supino');
            } else {
                $user->supino = $user->supino;
            }
            if ($request->has('agachamento')) {
                $user->agachamento = $request->input('agachamento');
            } else {
                $user->agachamento = $user->agachamento;
            }
            if ($request->has('levantamento')) {
                $user->levantamento = $request->input('levantamento');
            } else {
                $user->levantamento = $user->levantamento;
            }
            if ($request->has('date')) {
                $user->date = $request->input('date');
            } else {
                $user->date = $user->date;
            }

            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return $e;
        }

    }
    public function getObjetiv()
    {
        // Obtém o ID do usuário logado
        $userId = Auth::id();

        // Busca os campos específicos da avaliação do usuário logado na base de dados
        $avaliacao = User::where('id', $userId)->latest()->select('peso_meta', 'supino', 'agachamento', 'levantamento', 'date')->first();

        return response()->json($avaliacao);
    }

}