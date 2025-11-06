<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->get();
        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Ongoing,Completed',
        ]);

        Project::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'budget' => $request->budget,
            'amount_paid' => 0,
            'remaining_amount' => $request->budget,
            'status' => $request->status,
            'date' => now(),
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $clients = User::where('role', 'client')->get();
        return view('projects.edit', compact('project', 'clients'));
    }

public function update(Request $request, $id)
{
    $project = Project::findOrFail($id);

    // ✅ Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'user_id' => 'required|exists:users,id',
        'budget' => 'required|numeric|min:0',
        'status' => 'required|in:Pending,Ongoing,Completed',
    ]);

    // ✅ Update basic fields
    $project->update([
        'name' => $request->name,
        'user_id' => $request->user_id,
        'budget' => $request->budget,
        'status' => $request->status,
    ]);

    // ✅ Recalculate financials
    $totalExpenses = $project->expenses()->sum(DB::raw('area * rate'));
    $totalPaid = $project->payments()->sum('amount');

    // Round to 2 decimals
    $totalExpenses = round($totalExpenses, 2);
    $totalPaid = round($totalPaid, 2);

    // If expenses are more than the budget, increase budget to match expenses
    if ($project->budget < $totalExpenses) {
        $project->budget = $totalExpenses;
        $remainingAmount = round($totalExpenses - $totalPaid, 2);
    } else {
        $remainingAmount = round($project->budget - $totalPaid, 2);
    }

    // Prevent negative remaining amount
    $remainingAmount = max($remainingAmount, 0);

    // ✅ Update project financials
    $project->amount_paid = $totalPaid;
    $project->remaining_amount = $remainingAmount;
    $project->save();

    return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
}


    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }




// public function showPayments(Request $request, $projectId)
// {
//     $project = Project::findOrFail($projectId);

//     // Base query
//     $query = $project->payments()->orderBy('date', 'asc');

//     // Apply filters
//     if ($request->filled('filter_type') && $request->filled('filter_value')) {
//         $type = $request->filter_type;
//         $value = $request->filter_value;

//         if ($type === 'date') {
//             $query->whereDate('date', $value);
//         } elseif ($type === 'month') {
//             $query->whereMonth('date', substr($value, 5, 2))
//                   ->whereYear('date', substr($value, 0, 4));
//         } elseif ($type === 'year') {
//             $query->whereYear('date', $value);
//         }
//     }

//     $payments = $query->get();

//     return view('projects.details', compact('project', 'payments'));
// }

public function showPayments(Request $request, $projectId)
{
    // Get the project with its user
    $project = Project::with('user')->findOrFail($projectId);
    $user = $project->user; // ✅ this is the actual project owner

    /*
    |--------------------------------------------------------------------------
    | PAYMENTS FILTER
    |--------------------------------------------------------------------------
    */
    $paymentsQuery = $project->payments()->orderBy('date', 'asc');

    if ($request->filled('payment_filter_type') && $request->filled('payment_filter_value')) {
        $type = $request->payment_filter_type;
        $value = $request->payment_filter_value;

        switch ($type) {
            case 'date':
                $paymentsQuery->whereDate('date', $value);
                break;
            case 'month':
                $year = substr($value, 0, 4);
                $month = substr($value, 5, 2);
                $paymentsQuery->whereYear('date', $year)->whereMonth('date', $month);
                break;
            case 'year':
                $paymentsQuery->whereYear('date', $value);
                break;
        }
    }

    $payments = $paymentsQuery->get();

    /*
    |--------------------------------------------------------------------------
    | EXPENSES FILTER
    |--------------------------------------------------------------------------
    */
    $expensesQuery = $project->expenses()->orderBy('date', 'asc');

    if ($request->filled('filter_type') && $request->filled('filter_value')) {
        $type = $request->filter_type;
        $value = $request->filter_value;

        switch ($type) {
            case 'date':
                $expensesQuery->whereDate('date', $value);
                break;
            case 'month':
                $year = substr($value, 0, 4);
                $month = substr($value, 5, 2);
                $expensesQuery->whereYear('date', $year)->whereMonth('date', $month);
                break;
            case 'year':
                $expensesQuery->whereYear('date', $value);
                break;
        }
    }

    $expenses = $expensesQuery->get();
    $totalExpense = $expenses->sum(fn($e) => $e->area * $e->rate);

    return view('projects.details', compact('project', 'user', 'payments', 'expenses', 'totalExpense'));
}



// update gst

public function updateGstAndDiscount(Request $request, $id)
{
    try {
        $project = \App\Models\Project::findOrFail($id);

        // Only admin can update
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate input
        $request->validate([
            'gst' => 'numeric|min:0|max:100',
            'discount' => 'numeric|min:0',
        ]);

        // Save values to DB
        $project->gst = $request->gst;
        $project->discount = $request->discount;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'GST and discount updated successfully',
            'gst' => $project->gst,
            'discount' => $project->discount,
        ]);
    } catch (\Exception $e) {
        // Debug: log the exact error
        \Log::error('GST/Discount update failed: '.$e->getMessage());
        return response()->json(['error' => 'Server error: '.$e->getMessage()], 500);
    }
}


}
