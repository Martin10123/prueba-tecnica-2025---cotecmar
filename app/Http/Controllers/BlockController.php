<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Project;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blocks = Block::where('deleted', false)
            ->with('project')
            ->get(['id', 'name', 'project_id']);

        $projects = Project::where('deleted', false)->get();

        return inertia('Blocks/Blocks', [
            'blocks' => $blocks,
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|unique:blocks,id',
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        Block::create($validated);

        return redirect()->route('blocks.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $block = Block::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $block->update($validated);

        return redirect()->route('blocks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $block = Block::findOrFail($id);
        $block->deleted = true;
        $block->save();

        return redirect()->route('blocks.index');
    }
}
