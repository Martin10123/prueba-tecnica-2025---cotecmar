<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::whereHas('blocks')
            ->with(['blocks' => function ($query) {
                $query->with(['pieces' => function ($q) {
                    $q->where('status', 'Pendiente');
                }]);
            }])
            ->get();

        return inertia('Dashboard', [
            'projects' => $projects
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pieceId' => 'required|exists:pieces,id',
            'realWeight' => 'required|numeric',
        ], [
            'pieceId.required' => 'Debe seleccionar una pieza',
            'realWeight.required' => 'Debe ingresar el peso real',
            'realWeight.numeric' => 'El peso real debe ser un número',
        ]);

        $piece = Piece::findOrFail($validated['pieceId']);
        $piece->real_weight = $validated['realWeight'];
        $piece->status = 'Fabricado';
        $piece->registered_by = Auth::id();
        $piece->registration_date = now();
        $piece->save();

        return redirect()->route('dashboard.index');
    }
}
