<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Admin;



//import auth facades
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Store a new admin.
     *
     * @param  Request  $request
     * @return Response
     */

        
     
     public function registerAdmin(Request $request)
     {
         //validate incoming request 
         $this->validate($request, [
             'username' => 'required|string',
             'password' => 'required',
         ]);
     
         try {
             
     
             $admin = new Admin;
             $admin->username = $request->input('username');
             $plainPassword = $request->input('password');
             $admin->password = app('hash')->make($plainPassword);

             $admin->save();
     
             //return successful response
             return response()->json(['admin' => $admin, 'message' => 'CREATED'], 201);
     
         } catch (\Exception $e) {
             //return error message
             return response()->json(['message' => 'User Registration Failed!'.$e], 409);
         }
     
     } 

   
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function loginAdmin(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
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

     public function update(Request $request, $id)
     {
         try
         {
             // verificar se o utilizador existe
             $admin = User::findOrFail($id);
 
             // dar update em todas as informações
             $admin->update($request->all());
 
             return response()->json(['admin' => $admin], 200);
         } catch (\Exception $e) {
             // utilizador não encontrado
             return response()->json(['message' => 'User Not Found!'], 404);
         }
     }
   
}