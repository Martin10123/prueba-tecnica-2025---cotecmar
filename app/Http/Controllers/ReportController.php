<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectsPending = Project::whereHas('blocks.pieces', function ($query) {
            $query->where('status', 'Pendiente');
        })
            ->with(['blocks' => function ($query) {
                $query->with(['pieces' => function ($q) {
                    $q->where('status', 'Pendiente');
                }]);
            }])
            ->get();

        $projectsStats = Project::with(['blocks.pieces'])->get()->map(function ($project) {
            $pendingCount = 0;
            $fabricatedCount = 0;

            foreach ($project->blocks as $block) {
                foreach ($block->pieces as $piece) {
                    if ($piece->status === 'Pendiente') {
                        $pendingCount++;
                    } elseif ($piece->status === 'Fabricado') {
                        $fabricatedCount++;
                    }
                }
            }

            return [
                'id' => $project->id,
                'name' => $project->name,
                'pending_count' => $pendingCount,
                'fabricated_count' => $fabricatedCount,
            ];
        });

        return inertia('Reports/Reports', [
            'projectsPending' => $projectsPending,
            'projectsStats' => $projectsStats,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
