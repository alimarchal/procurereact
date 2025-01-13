<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Exception;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|string|in:Super Admin,Admin Support,Admin,Team Member,IBR',
            'ibr_no' => 'nullable|string|max:255',
        ]);

        try {
            // Begin database transaction
            return DB::transaction(function() use ($validated, $request) {
                // Create new user with validated data
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'ibr_no' => $validated['ibr_no'] ?? null, // Add IBR number if provided
                ]);

                // Assign role based on type (defaults to Admin)
                $role = Role::findByName($request->type ?? 'Admin');
                $user->assignRole($role);

                // Get role permissions
                $permissions = $role->permissions->pluck('name');

                // Return success response with user data and token
                return response()->json([
                    'user' => UserResource::make($user),
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'role' => $role->name,
                    'permissions' => $permissions,
                    'message' => 'User registered successfully'
                ], 201);
            });
        } catch (Exception $e) {
            // Return error response if registration fails
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Please enter your email',
            'email.email' => 'Invalid email format',
            'password.required' => 'Please enter your password'
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        // Get user role and permissions
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'])
            : response()->json(['message' => 'Unable to send reset link'], 400);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
