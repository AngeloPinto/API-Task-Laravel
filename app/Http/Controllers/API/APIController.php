<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Add
use JWTAuth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegistrationFormRequest;

class APIController extends Controller
{

    /**
     * @group Auth
     * Registrar 
     * Registra um novo usuário
     * 
     * @bodyParam name string required O nome do usuário. Example: Pedro
     * @bodyParam email string required O e-mail usuário. Example: email@email.com.br
     * @bodyParam password string required A senha de acesso para usuário. Example: senha123
     * 
     * @response 200 {
     *  "success": true,
     *  "user": {
     *  "name": "rafael",
     *        "email": "rafael@gmail.com",
     *        "id": 4
     *    }
     * }    
     * 
     * @response 422 
    *     {
    *    "message": "The given data was invalid.",
    *    "errors": {
    *        "email": [
    *            "The email field is required."
    *        ]
    *    }
    *}

    * @response 422
    * {
    *    "message": "The given data was invalid.",
    *    "errors": {
    *        "email": [
    *            "The email has already been taken."
    *        ]
    *    }
    *}
    * @param RegistrationFormRequest $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function register(Request $request)
    {

        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:10'
        ];        

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'success'   =>  true,
            'user'      =>  $user
        ], 200);
    }


    /**
     * @group Auth
     * Login 
     * Efetua o login de um usuário
     * 
     * @bodyParam email    string required E-mail do usuário. Example: email@email.com.br
     * @bodyParam password string required Senha do usuário. Example: teste123
     * 
     * @response 200 
     * {
     *    "success": true,
     *    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOl..."
     * }
     * 
     * @response 400
     * {
     *      "success": false,
     *      "message": "Invalid Email or Password"
     * }
     *  
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */    
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token'   => $token,
        ]);
    }    


    /**
     * @group Auth
     * Logout
     * Efetua o logout do usuário - invalida o token. 
     * 
     * @urlParam  token string required O token para cancelar. Example: eyJ0eXAiOiJKV1QiLCJhbGciOi...
     * @bodyParam token string required O token para cancelar. Example: eyJ0eXAiOiJKV1QiLCJhbGciOi...
     * 
     * @response 200
     * {
     *      "success": true,
     *      "message": "User logged out successfully"
     * }
     * 
     * @response 401
     * {
     *      "message": "The token has been blacklisted"
     * }
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */    
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }  

    /**
     * @group Auth
     * Me
     * Lista dados do usuário logado com base no token
     * 
     * @urlParam token string required Token do usuário. Example: eyJ0eXAiOiJKV1QiLCJhbGciOi...
     * 
     * @bodyParam name string required description. Example: angelo
     * 
     * @response 200
     * {
     *     "id": 1,
     *     "name": "nome_usuario",
     *     "email": "email@email.com.br"
     * }
     * 
     * @response 401
     * {
     *     "message": "Token not provided"
     * }
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }    
}
