@extends('layout.master')

@section('content')
<div class="container">
    <h1>Transactions</h1>
    
    <!-- Add Transaction Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
        Add Transaction
    </button>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered mt-3">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Date & Time</th>
                <th>Screenshot</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->user->full_name }}</td>
                <td>{{ $transaction->membershipPlan->name }}</td>
                <td>₹{{ number_format($transaction->amount, 2) }}</td>
                <td>{{ $transaction->payment_method }}</td>
                <td>
                    <span class="badge 
                        @if($transaction->status == 'completed') badge-success 
                        @elseif($transaction->status == 'pending') badge-warning 
                        @else badge-danger @endif">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                <td>
                    @if ($transaction->screenshot)
                    <img src="{{ asset('storage/' . $transaction->screenshot) }}" alt="Screenshot" width="100" class="img-thumbnail">
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTransactionModal" 
                            data-transaction-id="{{ $transaction->id }}"
                            data-user-id="{{ $transaction->user_id }}"
                            data-plan-id="{{ $transaction->membership_plan_id }}"
                            data-amount="{{ $transaction->amount }}"
                            data-method="{{ $transaction->payment_method }}"
                            data-status="{{ $transaction->status }}">
                        Edit
                    </button>
                    <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $transactions->links() }}
    
    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="membership_plan_id">Plan</label>
                            <select name="membership_plan_id" id="membership_plan_id" class="form-control" required>
                                <option value="">Select Plan</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} - ₹{{ $plan->price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="UPI">UPI</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="screenshot">Screenshot</label>
                            <input type="file" name="screenshot" id="screenshot" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Transaction Modal -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTransactionForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_user_id">User</label>
                            <select name="user_id" id="edit_user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_membership_plan_id">Plan</label>
                            <select name="membership_plan_id" id="edit_membership_plan_id" class="form-control" required>
                                <option value="">Select Plan</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} - ₹{{ $plan->price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_amount">Amount</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_payment_method">Payment Method</label>
                            <select name="payment_method" id="edit_payment_method" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="UPI">UPI</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_screenshot">Screenshot</label>
                            <input type="file" name="screenshot" id="edit_screenshot" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editTransactionModal');
    
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const transactionId = button.getAttribute('data-transaction-id');
        const userId = button.getAttribute('data-user-id');
        const planId = button.getAttribute('data-plan-id');
        const amount = button.getAttribute('data-amount');
        const method = button.getAttribute('data-method');
        const status = button.getAttribute('data-status');
        
        // Set form action
        const form = document.getElementById('editTransactionForm');
        form.action = `/admin/transactions/${transactionId}`;
        
        // Set form values
        document.getElementById('edit_user_id').value = userId;
        document.getElementById('edit_membership_plan_id').value = planId;
        document.getElementById('edit_amount').value = amount;
        document.getElementById('edit_payment_method').value = method;
        document.getElementById('edit_status').value = status;
    });
});
</script>
@endsection
