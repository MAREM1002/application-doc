<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Passer les utilisateurs à la vue
        return view('users.index', compact('users'));
    }
    
    

    public function deleteUser(Request $request, $id)
    {
    // Vérifiez si l'utilisateur actuel est un admin
    if (auth()->user()->usertype !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
    }

    // Vérification du mot de passe admin
    if (!Hash::check($request->password, auth()->user()->password)) {
        return response()->json(['success' => false, 'message' => 'Invalid password.'], 403);
    }

    // Recherchez l'utilisateur à supprimer
    $user = User::find($id);
    
    if ($user) {
        // Supprimez l'utilisateur
        $user->delete();
        // Return response only for debugging if needed
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'User not found.'], 404);
    }
    }
    public function updateRoles(Request $request, $id)
{
    // Check if the current user is an admin
    if (auth()->user()->usertype !== 'admin') {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Validate incoming request
    $request->validate([
        'roles' => 'array',
        'roles.*' => 'string',
    ]);

    $user = User::findOrFail($id);

    // Update the user's roles (implementation depends on how roles are managed in your app)
    // For example, you might use a roles() relationship:
    $user->roles()->sync($request->roles);

    return response()->json(['message' => 'Roles updated successfully.']);
}


}

