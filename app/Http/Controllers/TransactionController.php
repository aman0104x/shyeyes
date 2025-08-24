<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\MembershipPlan;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'membershipPlan'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users = User::all();
        $plans = MembershipPlan::active()->get();

        return view('admin.transactions.index', compact('transactions', 'users', 'plans'));
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $screenshotFile = $request->file('screenshot');
            $screenshotName = time() . '_' . $screenshotFile->getClientOriginalName();
            $screenshotPath = $screenshotFile->storeAs('transaction_screenshots', $screenshotName, 'public');
            $validated['screenshot'] = $screenshotPath;
        }

        Transaction::create($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_plan_id' => 'required|exists:membership_plans,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'status' => 'required|in:pending,completed,failed',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $screenshotFile = $request->file('screenshot');
            $screenshotName = time() . '_' . $screenshotFile->getClientOriginalName();
            $screenshotPath = $screenshotFile->storeAs('transaction_screenshots', $screenshotName, 'public');
            $validated['screenshot'] = $screenshotPath;
        } else {
            // Keep the existing screenshot if no new file is uploaded
            unset($validated['screenshot']);
        }

        $transaction->update($validated);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
