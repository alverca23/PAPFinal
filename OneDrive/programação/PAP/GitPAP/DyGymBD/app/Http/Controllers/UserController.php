<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    public function name()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    public function sendInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //validate incoming request 
        $this->validate($request, [
            'birthday' => 'required|string',
            'height' => 'required|string',
            'weight' => 'required|string',
            'hobbies' => 'required|string',

        ]);

        try {

            $user = Auth::user();
            $user->birthday = $request->input('birthday');
            $user->height = $request->input('height');
            $user->weight = $request->input('weight');
            $user->hobbies = $request->input('hobbies');
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'send info Failed!' . $e], 409);
        }

    }

    public function updates(Request $request)
    {

        $user = Auth::user();

        $this->validate($request, [
            'birthday' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'hobbies' => 'required',
        ]);


        if ($request->has('birthday')) {
            $user->birthday = $request->input('birthday');
        } else {
            $user->birthday = $user->birthday;
        }
        if ($request->has('height')) {
            $user->height = $request->input('height');
        } else {
            $user->height = $user->height;
        }
        if ($request->has('weight')) {
            $user->weight = $request->input('weight');
        } else {
            $user->weight = $user->weight;
        }
        if ($request->has('hobbies')) {
            $user->hobbies = $request->input('hobbies');
        } else {
            $user->hobbies = $user->hobbies;
        }

        $user->save();

        return response()->json(["status" => "updated", $user], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado.'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'weight' => $user->weight,
            'height' => $user->height,
            'birthday' => $user->birthday,
        ]);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json(['users' => User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json($user, 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function GetAuthUser()
    {
        try {

            $user = auth()->user();

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

}