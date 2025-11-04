<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Project;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Expense::with('project.user')->latest();

        // 🧰 Filter by User ID (Client)
        if ($request->filled('user_id')) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        $expenses = $query->get();

        // 🧾 For filter dropdown
        $users = \App\Models\User::all();

        return view('expenses.index', compact('expenses', 'users'));
    }


    public function create()
    {
        $projects = Project::all();
        return view('expenses.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'description' => 'required|string|max:255',
            'spec' => 'nullable|string|max:255',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'rate' => 'required|numeric|min:0',
        ]);

        // Calculate area (not rounded)
        $area = $request->length * $request->width;

        Expense::create([
            'project_id' => $request->project_id,
            'description' => $request->description,
            'spec' => $request->spec,
            'length' => $request->length,
            'width' => $request->width,
            'area' => $area,
            'unit' => $request->unit,
            'rate' => $request->rate,
            'date' => now(),
        ]);

        $this->recalculateProjectRemaining($request->project_id);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $projects = Project::all();
        return view('expenses.edit', compact('expense', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'description' => 'required|string|max:255',
            'spec' => 'nullable|string|max:255',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'rate' => 'required|numeric|min:0',
        ]);

        $oldProjectId = $expense->project_id;
        $area = $request->length * $request->width;

        $expense->update([
            'project_id' => $request->project_id,
            'description' => $request->description,
            'spec' => $request->spec,
            'length' => $request->length,
            'width' => $request->width,
            'area' => $area,
            'unit' => $request->unit,
            'rate' => $request->rate,
        ]);

        // Recalculate remaining amount for both old & new project if changed
        $this->recalculateProjectRemaining($oldProjectId);
        if ($oldProjectId != $request->project_id) {
            $this->recalculateProjectRemaining($request->project_id);
        }

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $projectId = $expense->project_id;

        $expense->delete();

        $this->recalculateProjectRemaining($projectId);

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }













    // private function recalculateProjectRemaining($projectId)
    // {
    //     $project = Project::findOrFail($projectId);

    //     // Calculate totals
    //     $totalExpenses = $project->expenses()->sum(DB::raw('area * rate'));
    //     $totalPaid = $project->payments()->sum('amount');

    //     // ✅ Round only totals
    //     $totalExpenses = round($totalExpenses, 2);
    //     $totalPaid = round($totalPaid, 2);
    //     $remainingAmount = round($totalExpenses - $totalPaid, 2);

    //     // Update project financials
    //     $project->amount_paid = $totalPaid;
    //     $project->budget = $totalExpenses;
    //     $project->remaining_amount = $remainingAmount;
    //     $project->save();
    // }



        private function recalculateProjectRemaining($projectId)
    {
        $project = Project::findOrFail($projectId);

        // Calculate totals
        $totalExpenses = $project->expenses()->sum(DB::raw('area * rate'));
        $totalPaid = $project->payments()->sum('amount');

        // ✅ Round only totals
        $totalExpenses = round($totalExpenses, 2);
        $totalPaid = round($totalPaid, 2);
        

        if($project->budget < $totalExpenses){
            $project->budget = $totalExpenses;
            $remainingAmount = round($totalExpenses - $totalPaid, 2);
        }
        else{
            $remainingAmount = round($project->budget - $totalPaid, 2);
        }

        // Update project financials
        $project->amount_paid = $totalPaid;
        $project->budget = $totalExpenses;
        $project->remaining_amount = $remainingAmount;
        $project->save();
    }

}
