<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Http\Request;
use App\Models\Pt;


//import auth facades
use Illuminate\Support\Facades\Auth;

class PtController extends Controller
{
    /**
     * Store a new pt.
     *
     * @param  Request  $request
     * @return Response
     */


    public function registerPt(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:pts',
            'password' => 'required|min:6',
            'plan' => 'required|'
        ]);

        try {


            $pt = new Pt;
            $pt->name = $request->input('name');
            $pt->email = $request->input('email');
            $pt->plan = $request->input('plan');
            $pt->id_conta = 1;
            $plainPassword = $request->input('password');
            $pt->password = app('hash')->make($plainPassword);

            $pt->save();

            //return successful response
            return response()->json(['pt' => $pt, 'message' => 'CREATED'], 201);

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
    

    public function loginPt(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        try {
            $pt = Pt::where('email', '=', $request->input('email'))->first();

            if ($pt && $pt->password === $request->input('password')) {
                // Senha está correta, faça o login
                return response()->json(['Pt' => $pt, 'message' => 'LOGIN'], 201);
            } else {
                // Credenciais inválidas
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }
        } catch (\Exception $e) {
            // Erro ao realizar o login
            return response()->json(['message' => 'Falha no login do Pt: ' . $e], 409);
        }
    }



    /**
     * Get a info.
     *
     * @param  Request  $request
     * @return Response
     */



}