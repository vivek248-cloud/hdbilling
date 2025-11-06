<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ClientLoginController extends Controller
{
    // Show client login form
    public function showLoginForm()
    {
        return view('client.login'); // create this Blade view next
    }

    // Handle client login
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');
        $remember = $request->filled('remember'); // ✅ Check if the remember checkbox is checked

        if (Auth::attempt(array_merge($credentials, ['role' => 'client']), $remember)) {
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors(['name' => 'Invalid credentials or not a client']);
    }

    // Logout client
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('client.login');
    }


// public function dashboard(Request $request)
// {
//     $user = auth()->user();

//     // 🔐 Only clients can access this dashboard
//     if ($user->role !== 'client') {
//         abort(403, 'Unauthorized');
//     }

//     // ✅ Fetch projects with relations
//     $projects = \App\Models\Project::with(['expenses', 'payments' => function ($query) use ($request) {

//         // ✅ Apply optional payment filters
//         if ($request->filled('payment_filter_type') && $request->filled('payment_filter_value')) {
//             $type = $request->payment_filter_type;
//             $value = $request->payment_filter_value;

//             switch ($type) {
//                 case 'date':
//                     $query->whereDate('date', $value);
//                     break;
//                 case 'month':
//                     $year = substr($value, 0, 4);
//                     $month = substr($value, 5, 2);
//                     $query->whereYear('date', $year)->whereMonth('date', $month);
//                     break;
//                 case 'year':
//                     $query->whereYear('date', $value);
//                     break;
//             }
//         }

//         $query->orderBy('date', 'asc');
//     }])
//     ->where('user_id', $user->id)
//     ->get();

//     return view('client.dashboard', compact('user', 'projects'));
// }


public function dashboard(Request $request)
{
    $user = auth()->user();

    // 🛡️ Only clients
    if ($user->role !== 'client') {
        abort(403, 'Unauthorized');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔍 Fetch Client's Projects with Expenses & Payments
    |--------------------------------------------------------------------------
    */
    $projects = Project::with(['expenses', 'payments' => function ($query) use ($request) {

        // ✅ Optional payment filters (already existed)
        if ($request->filled('payment_filter_type') && $request->filled('payment_filter_value')) {
            $type = $request->payment_filter_type;
            $value = $request->payment_filter_value;

            switch ($type) {
                case 'date':
                    $query->whereDate('date', $value);
                    break;
                case 'month':
                    $year = substr($value, 0, 4);
                    $month = substr($value, 5, 2);
                    $query->whereYear('date', $year)->whereMonth('date', $month);
                    break;
                case 'year':
                    $query->whereYear('date', $value);
                    break;
            }
        }

        $query->orderBy('date', 'asc');
    }])
    ->where('user_id', $user->id)
    ->get();

    /*
    |--------------------------------------------------------------------------
    | 🧮 Optional Expense Filtering (new)
    |--------------------------------------------------------------------------
    */
    $filterType = $request->get('filter_type');
    $filterValue = $request->get('filter_value');

    $expensesQuery = \App\Models\Expense::query()
        ->whereHas('project', fn($q) => $q->where('user_id', $user->id));

    if ($filterType && $filterValue) {
        switch ($filterType) {
            case 'date':
                $expensesQuery->whereDate('date', $filterValue);
                break;
            case 'month':
                $year = substr($filterValue, 0, 4);
                $month = substr($filterValue, 5, 2);
                $expensesQuery->whereYear('date', $year)->whereMonth('date', $month);
                break;
            case 'year':
                $expensesQuery->whereYear('date', $filterValue);
                break;
        }
    }

    $expenses = $expensesQuery->with(['floorType', 'roomType'])->orderBy('date', 'desc')->get();

    $totalExpense = $expenses->sum(fn($e) => $e->area * $e->rate);

    return view('client.dashboard', compact('user', 'projects', 'expenses', 'totalExpense', 'filterType', 'filterValue'));
}




}
