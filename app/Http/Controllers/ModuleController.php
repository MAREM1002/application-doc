<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        return response()->json($modules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $module = Module::create($request->all());
        return response()->json($module, 201);
    }

    public function update(Request $request, Module $module)
    {
        $module->update($request->all());
        return response()->json($module);
    }

    public function destroy(Module $module)
    {
        $module->delete();
        return response()->json(null, 204);
    }
}
