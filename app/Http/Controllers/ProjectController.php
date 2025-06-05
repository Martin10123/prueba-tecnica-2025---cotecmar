<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('deleted', false)->get();

        return inertia('Projects/Projects', [
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|unique:projects,id',
            'name' => 'required|string|max:255',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            // El id no se cambia, por eso solo validamos el name
            'name' => 'required|string|max:255',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        // Cambiar deleted a true en vez de eliminar físicamente
        $project->deleted = true;
        $project->save();

        return redirect()->route('projects.index');
    }
}
