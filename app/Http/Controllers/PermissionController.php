<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function showPermissions()
{
    $users = User::all(); // Assurez-vous que ceci retourne une collection ou un tableau
    $permissions = Permission::all(); // Assurez-vous que ceci retourne une collection ou un tableau

    return view('users.index', compact('users', 'permissions'));
}


    public function updatePermissions(Request $request, User $user)
    {
        $user->syncPermissions($request->permissions);

        return redirect()->route('permissions.index')->with('success', 'Permissions mises à jour avec succès!');
    }
}
