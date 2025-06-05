<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PieceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pieces = Piece::where('deleted', false)
            ->with(['block.project', 'registeredBy'])
            ->get();

        $blocks = Block::where('deleted', false)->with('project')->get();

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
        $validated = $request->validate([
            'code' => 'required|string|unique:pieces,code',
            'theoretical_weight' => 'required|numeric|min:0',
            'real_weight' => 'nullable|numeric|min:0',
            'status' => 'required|in:Pendiente,Fabricado',
            'block_id' => 'required|string|exists:blocks,id',
        ]);

        $validated['registration_date'] = now();
        $validated['registered_by'] = Auth::id();

        Piece::create($validated);

        return redirect()->route('pieces.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
            'block_id' => 'required|string|exists:blocks,id',
        ]);

        $validated['registration_date'] = now();

        $piece->update($validated);

        return redirect()->route('pieces.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $piece = Piece::findOrFail($id);
        $piece->deleted = true;
        $piece->save();

        return redirect()->route('pieces.index');
    }
}
