<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
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
            'parent_id' => 'required|string|max:255',
        ]);

        try {
            // Begin database transaction
            return DB::transaction(function() use ($validated, $request) {
                // Create new user with validated data
                $user = User::create([
                    'parent_id' => $validated['parent_id'] ?? null,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'type' => $validated['type'] ?? 'Admin',
                    'is_active' => 'Yes',
                    'is_super_admin' => 'No',
                    'gender' => $validated['gender'] ?? null,
                    'country_of_business' => $validated['country_of_business'] ?? null,
                    'city_of_business' => $validated['city_of_business'] ?? null,
                    'country_of_bank' => $validated['country_of_bank'] ?? null,
                    'bank' => $validated['bank'] ?? null,
                    'iban' => $validated['iban'] ?? null,
                    'currency' => $validated['currency'] ?? null,
                    'mobile_number' => $validated['mobile_number'] ?? null,
                    'dob' => $validated['dob'] ?? null,
                    'mac_address' => $validated['mac_address'] ?? null,
                    'device_name' => $validated['device_name'] ?? null,
                ]);

                // Create wallet for new user
                Wallet::create(['user_id' => $user->id]);

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

        // Revoke all previous tokens for the user
        $user->tokens()->delete();

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
