<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BlockController extends Controller
{
    public function index()
    {
        try {
            $blocks = Block::with('project')->get(['id', 'block_id', 'name', 'project_id']);
            $projects = Project::all();

            return inertia('Blocks/Blocks', [
                'blocks' => $blocks,
                'projects' => $projects,
            ]);
        } catch (Exception $e) {
            Log::error('Error al cargar bloques: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al cargar los bloques.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'block_id' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
            ]);

            $existingBlock = Block::withTrashed()
                ->where('block_id', $request->block_id)
                ->first();

            if ($existingBlock) {
                if ($existingBlock->trashed()) {
                    // Si estaba eliminado, restaurar y actualizar datos
                    $existingBlock->restore();
                    $existingBlock->update([
                        'name' => $request->name,
                        'project_id' => $request->project_id,
                    ]);
                } else {
                    // Ya existe sin estar eliminado -> error de validación
                    throw ValidationException::withMessages([
                        'block_id' => 'El ID del bloque ya está en uso.',
                    ]);
                }
            } else {
                // Crear nuevo bloque
                Block::create($request->only('block_id', 'name', 'project_id'));
            }

            return redirect()->route('blocks.index')->with('success', 'Bloque creado correctamente.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Error al crear bloque: ' . $th->getMessage());

            // Si usas Inertia, puedes retornar la vista con error y datos
            return inertia('Blocks/Blocks', [
                'error' => 'Error al guardar el bloque: ' . $th->getMessage(),
                'blocks' => Block::with('project')->get(),
                'projects' => Project::all(),
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $block = Block::findOrFail($id);

            $validated = $request->validate([
                'block_id' => 'required|string|unique:blocks,block_id,' . $block->id,
                'name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
            ]);

            $block->update($validated);

            return redirect()->route('blocks.index')->with('success', 'Bloque actualizado correctamente.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Bloque no encontrado: ' . $id);
            return redirect()->back()->with('error', 'El bloque no fue encontrado.');
        } catch (Exception $e) {
            Log::error('Error al actualizar bloque: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el bloque.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $block = Block::findOrFail($id);
            $block->delete();

            return redirect()->route('blocks.index')->with('success', 'Bloque eliminado correctamente.');
        } catch (ModelNotFoundException $e) {
            Log::warning('Intento de eliminar bloque inexistente: ' . $id);
            return redirect()->back()->with('error', 'El bloque no fue encontrado.');
        } catch (Exception $e) {
            Log::error('Error al eliminar bloque: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el bloque.');
        }
    }
}