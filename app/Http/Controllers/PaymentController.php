<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PaymentController extends Controller
{
    /**
     * Display all payments.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Payment::with('project.user')->latest();

        // 🧰 Filter by User ID (Client)
        if ($request->filled('user_id')) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        $payments = $query->get();

        // 🧾 For filter dropdown
        $users = \App\Models\User::all();

        return view('payments.index', compact('payments', 'users'));
    }



    /**
     * Show form to create a new payment.
     */
    public function create()
    {
        $projects = Project::with('user')->get();
        return view('payments.create', compact('projects'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:Cash,Online,Cheque',
            'date' => 'required|date',
        ]);

        Payment::create([
            'project_id' => $request->project_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'date' => $request->date,
        ]);

        $this->recalculateProjectRemaining($request->project_id);

        return redirect()->route('payments.index')->with('success', 'Payment added successfully!');
    }

    /**
     * Show form to edit an existing payment.
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $projects = Project::with('user')->get();
        return view('payments.edit', compact('payment', 'projects'));
    }

    /**
     * Update an existing payment.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:Cash,Online,Cheque',
            'date' => 'required|date',
        ]);

        $oldProjectId = $payment->project_id;

        $payment->update([
            'project_id' => $request->project_id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'date' => $request->date,
        ]);

        // Recalculate remaining amounts for old and new projects
        $this->recalculateProjectRemaining($oldProjectId);

        if ($oldProjectId != $request->project_id) {
            $this->recalculateProjectRemaining($request->project_id);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Payment updated successfully!');
    }

    /**
     * Delete a payment.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $projectId = $payment->project_id;

        $payment->delete();

        $this->recalculateProjectRemaining($projectId);

        return redirect()->route('admin.dashboard')->with('success', 'Payment deleted successfully!');
    }

    /**
     * Recalculate cumulative and remaining amounts for a project.
     */
    // private function recalculateProjectRemaining($projectId)
    // {
    //     $project = Project::findOrFail($projectId);

    //     $totalExpenses = $project->expenses()->sum(DB::raw('area * rate'));
    //     $totalPaid = $project->payments()->sum('amount'); // If you have a Payment model

    //     // Add expenses to budget
    //     $project->amount_paid = $totalPaid;
    //     $project->budget =$totalExpenses; // Keep the original budget
    //     $project->remaining_amount = $project->budget - $totalPaid;
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



    // invoice


   public function invoice($paymentId)
{
    // 🔸 Load payment with related project, user, and expenses
    $payment = \App\Models\Payment::with('project.user', 'project.expenses')->findOrFail($paymentId);
    $project = $payment->project;
    $projectOwner = $project->user;
    $loggedInUser = auth()->user();

    // 🛡️ Access control — Allow Admin OR Client who owns this project
    if ($loggedInUser->role !== 'admin' && $project->user_id !== $loggedInUser->id) {
        abort(403, 'Unauthorized Access');
    }

    /*
    |--------------------------------------------------------------------------
    | 💰 Calculate total expenses
    |--------------------------------------------------------------------------
    */
    $totalExpense = $project->expenses->sum(fn($e) => $e->area * $e->rate);

    /*
    |--------------------------------------------------------------------------
    | 🧾 Fetch all payments up to this one
    |--------------------------------------------------------------------------
    */
    $paymentsUpToNow = $project->payments()
        ->where('id', '<=', $payment->id)
        ->orderBy('id')
        ->get();

    $paymentRows = [];
    $cumulativePaid = 0;
    $previousPaymentAmount = null;

    foreach ($paymentsUpToNow as $p) {
        $paymentDate = \Carbon\Carbon::parse($p->date)->format('d-m-Y');
        $cumulativePaid += $p->amount;
        $remainingAfter = $totalExpense - $cumulativePaid;

        $paymentRows[] = [
            'date' => $paymentDate,
            'amount' => $p->amount,
            'previous_payment' => $previousPaymentAmount,
            'remaining_after_payment' => $remainingAfter,
            'payment_mode' => $p->payment_mode,
        ];

        $previousPaymentAmount = $p->amount;
    }

    /*
    |--------------------------------------------------------------------------
    | 🧾 Generate custom invoice number
    |--------------------------------------------------------------------------
    */
    $now = \Carbon\Carbon::now();
    $clientFirstName = strtoupper(substr($project->client_name, 0, strpos($project->client_name, ' ') ?: 1));
    $userIdLastDigit = substr($project->user_id, -1);
    $projectIdLastDigit = substr($project->id, -1);
    $paymentIdLastDigit = substr($payment->id, -1);
    $monthDigit = $now->format('m');
    $yearLastDigit = substr($now->format('Y'), -1);

    $invoiceNumber = $clientFirstName . $userIdLastDigit . $projectIdLastDigit . $paymentIdLastDigit . $monthDigit . $yearLastDigit;

    /*
    |--------------------------------------------------------------------------
    | 🧾 Return view with all invoice data
    |--------------------------------------------------------------------------
    */
    return view('payments.invoice', [
        'project' => $project,
        'user' => $projectOwner,
        'payment' => $payment,
        'expenses' => $project->expenses,
        'total_expense' => $totalExpense,
        'payment_rows' => $paymentRows,
        'total_received' => $cumulativePaid,
        'yet_to_receive' => $totalExpense - $cumulativePaid,
        'invoice_number' => $invoiceNumber,
        'invoice_date' => $now->format('d-m-Y'),
    ]);
}



//temp invoice for whatsapp link

public function temporaryInvoice($paymentId)
{
    $payment = \App\Models\Payment::findOrFail($paymentId);

    // Redirect to the real invoice blade page
    return redirect()->route('payments.invoice', $payment->id);
}




}
