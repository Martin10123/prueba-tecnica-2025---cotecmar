<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = Project::all();

            return inertia('Projects/Projects', [
                'projects' => $projects,
            ]);
        } catch (\Throwable $th) {
            // Manejo de errores, podrías registrar el error o mostrar un mensaje
            return inertia('Error', [
                'message' => 'Error al cargar los proyectos: ' . $th->getMessage(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required|string',
                'name' => 'required|string|max:255',
            ]);

            $existingProject = Project::withTrashed()
                ->where('project_id', $request->project_id)
                ->first();

            if ($existingProject) {
                if ($existingProject->trashed()) {
                    $existingProject->restore();
                    $existingProject->update(['name' => $request->name]);
                } else {
                    throw ValidationException::withMessages([
                        'project_id' => 'El ID del proyecto ya está en uso.',
                    ]);
                }
            } else {
                Project::create($request->only('project_id', 'name'));
            }

            return redirect()->route('projects.index');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return inertia('Projects/Projects', [
                'error' => 'Error al guardar el proyecto: ' . $th->getMessage(),
                'projects' => Project::all(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $project = Project::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $project->update($validated);

            return redirect()->route('projects.index');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Error al actualizar el proyecto: ' . $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return redirect()->route('projects.index');
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Error al eliminar el proyecto: ' . $th->getMessage()]);
        }
    }
}