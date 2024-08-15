<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class UsersController extends Controller
{
    public function currentUser()
{
    return response()->json([
        'user' => Auth::user()
    ]);
}

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Display the login form.
     */
    public function login()
    {
        return response()->json([
            'message' => 'Login form'
        ]);
    }

    /**
     * Authenticate a user.
     */
    public function auth(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Authenticated successfully',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } else {
            return response()->json([
                'error' => 'Email or password is incorrect'
            ], 401); // Unauthorized
        }
    }

    /**
     * Log out the user.
     */
    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'tel' => 'required',
            'ville' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'tel' => $request->tel,
            'ville' => $request->ville,
        ]);

        /*
        return response()->json([
            'message' => 'Account created successfully',
            'user' => $user
        ], 201); // Created
        */
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    /**
     * Display the registration form.
     */
    public function create()
    {
        return response()->json([
            'message' => 'Registration form'
        ]);
    }

    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
