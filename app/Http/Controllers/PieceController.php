<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pieces = Piece::with(['block.project', 'registeredBy'])->get();

        // Quitar filtro deleted para testear
        $blocks = Block::with('project')->get();

        $authUser = Auth::user();

        return inertia('Pieces/Pieces', [
            'pieces' => $pieces,
            'blocks' => $blocks,
            'authUser' => $authUser,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|unique:pieces,code',
                'theoretical_weight' => 'required|numeric|min:0',
                'real_weight' => 'nullable|numeric|min:0',
                'status' => 'required|in:Pendiente,Fabricado',
                'block_id' => 'required|integer|exists:blocks,id',
            ]);

            $validated['registration_date'] = now();
            $validated['registered_by'] = Auth::id();

            Piece::create($validated);

            return redirect()->route('pieces.index')->with('success', 'Pieza creada correctamente.');
        } catch (\Throwable $e) {
            // Aquí puedes loggear el error con Log::error($e) si quieres
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la pieza: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $piece = Piece::findOrFail($id);

            $validated = $request->validate([
                'code' => [
                    'required',
                    'string',
                    Rule::unique('pieces', 'code')->ignore($piece->id),
                ],
                'theoretical_weight' => 'required|numeric|min:0',
                'real_weight' => 'nullable|numeric|min:0',
                'status' => 'required|in:Pendiente,Fabricado',
                'block_id' => 'required|integer|exists:blocks,id',
            ]);

            $piece->update($validated);

            return redirect()->route('pieces.index')->with('success', 'Pieza actualizada correctamente.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar la pieza: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $piece = Piece::findOrFail($id);
            $piece->delete();

            return redirect()->route('pieces.index')->with('success', 'Pieza eliminada correctamente.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la pieza: ' . $e->getMessage()]);
        }
    }
}