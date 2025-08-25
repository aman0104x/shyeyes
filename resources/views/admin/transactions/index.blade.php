@extends("layout.master") {{-- Your admin master layout --}}

@section("title", "Transaction Management")

@section("content")
	<style>
		/* ===== Improved Layout Styles ===== */
		.transaction-management-tm {
			overflow-x: auto;
			padding: 30px;
			background: #f7d2e6c4;
			border-radius: 12px;
			box-shadow: 0 0 40px rgba(53, 31, 31, 0.05);
			height: 100%;
			margin: 0 auto;
			font-family: 'Segoe UI', sans-serif;
		}
		

		.section-title-tm {
			font-size: 28px;
			color: #ff4081;
			margin-bottom: 20px;
			font-family: 'Pacifico', cursive;
		}

		.top-bar-tm {
			display: flex;
			justify-content: space-between;
			margin-bottom: 15px;
			flex-wrap: wrap;
			gap: 10px;
		}

		.search-box-tm,
		.status-filter-tm {
			padding: 10px 15px;
			border: 1px solid #ccc;
			border-radius: 8px;
			box-sizing: border-box;
		}

		.search-box-tm {
			width: 250px;
		}

		.status-filter-tm {
			width: 150px;
		}

		.transaction-table-tm {
			width: 100%;
			border-collapse: collapse;
			text-align: center;
			min-width: 800px;
		}

		.transaction-table-tm th,
		.transaction-table-tm td {
			padding: 19px 12px;
			border-bottom: 1px solid #eee;
			white-space: nowrap;
		}

		/* Responsive table cell widths */
		.transaction-table-tm th:nth-child(3),
		.transaction-table-tm td:nth-child(3) {
			max-width: 120px;
			min-width: 100px;
		}

		/* Ensure action buttons stay within cell */
		.transaction-table-tm td:last-child {
			min-width: 200px;
			max-width: 250px;
			white-space: normal;
			text-align: center;
			vertical-align: middle;
			overflow: visible;
		}

		/* Proper button alignment */
		.btn-tm {
			padding: 6px 10px;
			border: none;
			border-radius: 6px;
			color: #fff;
			margin: 2px;
			cursor: pointer;
			min-width: 65px;
			white-space: nowrap;
			font-size: 13px;
			display: inline-block;
			vertical-align: middle;
			flex-shrink: 0;
		}

		/* Button container for responsive alignment */
		.action-buttons {
			display: flex;
			flex-wrap: wrap;
			gap: 3px;
			justify-content: center;
			align-items: center;
			white-space: normal;
			max-width: 100%;
			overflow: visible;
		}

		/* Responsive button layout - improved for zoom */
		@media (max-width: 1200px) {
			.transaction-table-tm td:last-child {
				min-width: auto;
				max-width: 200px;
			}

			.action-buttons {
				gap: 2px;
			}

			.btn-tm {
				padding: 5px 8px;
				font-size: 12px;
				min-width: 60px;
			}
		}

		@media (max-width: 992px) {
			.transaction-table-tm td:last-child {
				min-width: auto;
				max-width: 180px;
			}

			.action-buttons {
				flex-direction: row;
				flex-wrap: wrap;
				gap: 2px;
			}

			.btn-tm {
				padding: 4px 6px;
				font-size: 11px;
				min-width: 55px;
				margin: 1px;
			}
		}

		@media (max-width: 768px) {
			.transaction-table-tm td:last-child {
				min-width: auto;
				max-width: 150px;
			}

			.action-buttons {
				flex-direction: column;
				align-items: stretch;
				gap: 2px;
			}

			.btn-tm {
				font-size: 11px;
				padding: 4px 6px;
				min-width: auto;
				width: 100%;
				margin: 1px 0;
			}
		}

		@media (max-width: 576px) {
			.transaction-table-tm td:last-child {
				min-width: auto;
				max-width: 130px;
			}

			.action-buttons {
				flex-direction: column;
				gap: 1px;
			}

			.btn-tm {
				font-size: 10px;
				padding: 3px 4px;
				min-width: auto;
				width: 100%;
			}
		}

		.status-tm {
			font-weight: bold;
			padding: 5px 10px;
			border-radius: 12px;
			font-weight: bold;
			display: inline-block;
			min-width: 60px;
			text-align: center;
		}

		.status-tm.completed {
			background-color: #52c41a;
			color: #fff;
		}

		.status-tm.pending {
			background-color: #faad14;
			color: #fff;
		}

		.status-tm.failed {
			background-color: #ff4d4f;
			color: #fff;
		}

		.btn-tm {
			padding: 6px 12px;
			border: none;
			border-radius: 6px;
			color: #fff;
			margin-right: 6px;
			cursor: pointer;
			min-width: 70px;
			white-space: nowrap;
			font-size: 14px;
		}

		.btn-tm.view {
			background-color: #2315e6;
		}

		.btn-tm.edit {
			background-color: #28a745;
		}

		.btn-tm.delete {
			background-color: #e57373;
		}

		/* Modal styles */
		.modal {
			display: none;
			position: fixed;
			z-index: 9999;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			align-items: center;
			justify-content: center;
		}

		.modal-content {
			background-color: #fff;
			padding: 20px 30px;
			border-radius: 12px;
			max-width: 500px;
			width: 90%;
			font-family: 'Segoe UI', sans-serif;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
		}

		.modal-content h3 {
			margin-top: 0;
			margin-bottom: 15px;
			color: #ff4081;
			font-family: 'Pacifico', cursive;
		}

		.modal-content label {
			display: block;
			margin: 10px 0 5px;
			font-weight: 600;
			font-size: 14px;
		}

		.modal-content input,
		.modal-content select {
			width: 100%;
			padding: 8px 10px;
			border: 1px solid #ccc;
			border-radius: 6px;
			font-size: 14px;
		}

		.modal-buttons {
			margin-top: 20px;
			text-align: right;
		}

		.btn-save {
			background-color: #28a745;
			color: white;
		}

		.btn-cancel {
			background-color: #ccc;
			color: #333;
		}

		/* Responsive */
		@media (max-width: 768px) {
			#sidebar-container {
				display: none;
			}

			.transaction-management-tm {
				margin-left: 0;
				padding: 15px;
			}

			.top-bar-tm {
				flex-direction: column;
				gap: 10px;
			}

			.search-box-tm,
			.status-filter-tm {
				width: 100%;
			}

			.transaction-table-tm {
				min-width: unset;
				font-size: 13px;
			}

			.transaction-table-tm th,
			.transaction-table-tm td {
				padding: 8px 10px;
			}

			.btn-tm {
				font-size: 12px;
				padding: 6px 10px;
				min-width: 60px;
			}

			.modal-content {
				max-width: 95%;
				padding: 15px 20px;
			}
		}
	</style>

	<!-- Toast Notification Styles -->
	<style>
		.toast-container {
			position: fixed;
			top: 20px;
			right: 20px;
			z-index: 10000;
			pointer-events: none;
		}

		.toast {
			background: #fff;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
			margin-bottom: 10px;
			max-width: 350px;
			min-width: 300px;
			overflow: hidden;
			transform: translateX(100%);
			transition: transform 0.3s ease-in-out;
			pointer-events: auto;
		}

		.toast.show {
			transform: translateX(0);
		}

		.toast-header {
			padding: 12px 16px;
			border-bottom: 1px solid #eee;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.toast-title {
			font-weight: 600;
			font-size: 14px;
			margin: 0;
		}

		.toast-close {
			background: none;
			border: none;
			font-size: 18px;
			cursor: pointer;
			color: #666;
		}

		.toast-body {
			padding: 12px 16px;
			font-size: 13px;
		}

		.toast-success {
			border-left: 4px solid #28a745;
		}

		.toast-success .toast-header {
			background-color: #d4edda;
			color: #155724;
		}

		.toast-error {
			border-left: 4px solid #dc3545;
		}

		.toast-error .toast-header {
			background-color: #f8d7da;
			color: #721c24;
		}

		.toast-warning {
			border-left: 4px solid #ffc107;
		}

		.toast-warning .toast-header {
			background-color: #fff3cd;
			color: #856404;
		}
		.status-dropdown {
  padding: 6px 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  background-color: #f9f9f9;
  color: #333;
  font-size: 14px;
  min-width: 120px;
  transition: all 0.2s ease;
  appearance: none; /* removes default OS styling */
  background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-caret-down-fill" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658A.5.5 0 0 1 2.875 5h10.25a.5.5 0 0 1 .424.76l-4.796 5.482a.5.5 0 0 1-.756 0z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 8px center;
  background-size: 16px;
}

.status-dropdown:hover {
  border-color: #999;
  background-color: #f1f1f1;
}

.status-dropdown:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}
.status-dropdown option[value="pending"] {
  background-color: #fff8e1;
  color: #ff9800;
}
.status-dropdown option[value="completed"] {
  background-color: #e8f5e9;
  color: #4caf50;
}
.status-dropdown option[value="failed"] {
  background-color: #ffebee;
  color: #f44336;
}

	</style>

	<!-- Toast Container -->
	<div class="toast-container" id="toastContainer"></div>

	<!-- CSRF Token for AJAX -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="transaction-management-tm">
		<h2 class="section-title-tm">💰 Manage Transactions</h2>
		
		<!-- Revenue Cards Section -->
		<div class="revenue-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
			<div class="revenue-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div>
						<h3 style="margin: 0; font-size: 16px; font-weight: 600;">Daily Income</h3>
						<p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">₹{{ number_format($dailyRevenue, 2) }}</p>
					</div>
					<div style="font-size: 32px;">📈</div>
				</div>
			</div>
			
			<div class="revenue-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div>
						<h3 style="margin: 0; font-size: 16px; font-weight: 600;">Weekly Income</h3>
						<p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">₹{{ number_format($weeklyRevenue, 2) }}</p>
					</div>
					<div style="font-size: 32px;">💰</div>
				</div>
			</div>
			
			<div class="revenue-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div>
						<h3 style="margin: 0; font-size: 16px; font-weight: 600;">Monthly Income</h3>
						<p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">₹{{ number_format($monthlyRevenue, 2) }}</p>
					</div>
					<div style="font-size: 32px;">💎</div>
				</div>
			</div>
			
			<div class="revenue-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div>
						<h3 style="margin: 0; font-size: 16px; font-weight: 600;">Total Revenue</h3>
						<p style="font-size: 24px; font-weight: bold; margin: 10px 0 0 0;">₹{{ number_format($totalRevenue, 2) }}</p>
					</div>
					<div style="font-size: 32px;">🏆</div>
				</div>
			</div>
		</div>

		<!-- Search & Filter & Export -->
		<div class="top-bar-tm">
			<div style="display: flex; gap: 10px; flex-wrap: wrap;">
				<input type="text" placeholder="Search transactions..." class="search-box-tm" id="searchInput" />
				<select class="status-filter-tm" id="statusFilter">
					<option value="all">All Status</option>
					<option value="completed">Completed</option>
					<option value="pending">Pending</option>
					<option value="failed">Failed</option>
				</select>
				<select class="status-filter-tm" id="dateFilter">
					<option value="all">All Time</option>
					<option value="today">Today</option>
					<option value="this_week">This Week</option>
					<option value="this_month">This Month</option>
				</select>
				<button class="btn-tm" style="background-color: #28a745;" onclick="exportToCSV()">📊 Export CSV</button>
				<button class="btn-tm" style="background-color: #17a2b8;" onclick="exportToExcel()">📈 Export Excel</button>
			</div>
		</div>

		
		<table class="transaction-table-tm" id="transactionTable">
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
    @forelse($transactions as $transaction)
      <tr
        data-id="{{ $transaction->id }}"
        data-user="{{ $transaction->user->full_name }}"
        data-plan="{{ $transaction->membershipPlan->name }}"
        data-amount="{{ $transaction->amount }}"
        data-method="{{ $transaction->payment_method }}"
        data-status="{{ $transaction->status }}"
        data-date="{{ $transaction->created_at->format('d M Y, H:i') }}"
        data-screenshot="{{ $transaction->screenshot ? asset('storage/' . $transaction->screenshot) : '' }}"
      >
        <td>{{ $transaction->user->full_name }}</td>
        <td>{{ $transaction->membershipPlan->name }}</td>
        <td>₹{{ number_format($transaction->amount, 2) }}</td>
        <td>{{ $transaction->payment_method }}</td>
        <td>
          <span class="status-tm {{ $transaction->status }}">
            {{ ucfirst($transaction->status) }}
          </span>
        </td>
        <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
        <td>
          @if ($transaction->screenshot)
            <img
              src="{{ asset('storage/' . $transaction->screenshot) }}"
              alt="Screenshot"
              width="60" height="60"
              style="object-fit: cover; border-radius: 4px;"
            >
          @else
            <span>No Screenshot</span>
          @endif
        </td>
        <td>
          <select class="status-dropdown" data-id="{{ $transaction->id }}">
            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="failed" {{ $transaction->status == 'failed' ? 'selected' : '' }}>Failed</option>
          </select>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="8">No transactions found</td>
      </tr>
    @endforelse
  </tbody>
</table>


		<!-- Pagination -->
		{{ $transactions->links() }}

	</div>

	<script>
  document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const routes = {
      updateTransaction: "{{ route('admin.transactions.update', ':id') }}"
    };

    const showToast = (type, title, msg, duration = 3000) => {
      const icons = { success: '✅', error: '❌' };
      const toast = document.createElement('div');
      toast.className = `toast toast-${type}`;
      toast.innerHTML = `
        <div class="toast-header">
          <span class="toast-title">${icons[type]} ${title}</span>
          <button class="toast-close" onclick="this.closest('.toast').remove()">&times;</button>
        </div>
        <div class="toast-body">${msg}</div>
      `;
      document.getElementById('toastContainer').appendChild(toast);
      setTimeout(() => toast.classList.add('show'), 100);
      setTimeout(() => toast.remove(), duration);
    };

    const dropdowns = document.querySelectorAll('.status-dropdown');
    dropdowns.forEach(dropdown => {
      dropdown.dataset.original = dropdown.value;

      dropdown.addEventListener('change', async function() {
        const transactionId = this.dataset.id;
        const newStatus = this.value;
        const prevStatus = this.dataset.original;

        this.disabled = true;
        this.dataset.tempHtml = this.innerHTML;
        this.innerHTML = `<option>Updating...</option>`;

        try {
          const res = await fetch(routes.updateTransaction.replace(':id', transactionId), {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ _method: 'PUT', status: newStatus })
          });

          if (!res.ok) throw new Error(`HTTP ${res.status}`);

          const data = await res.json();
          if (!data.success) throw new Error(data.message || 'Update failed');

          // Update status in table row
          const row = document.querySelector(`tr[data-id="${transactionId}"]`);
          if (row) {
            const span = row.querySelector('.status-tm');
            span.className = `status-tm ${newStatus}`;
            span.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            row.setAttribute('data-status', newStatus);
          }

          this.dataset.original = newStatus;
          showToast('success', 'Status Updated', `Status updated to ${newStatus}!`);
        } catch (e) {
          console.error('Status update error:', e);
          this.value = prevStatus;
          showToast('error', 'Update Failed', e.message);
        } finally {
          this.disabled = false;
          this.innerHTML = this.dataset.tempHtml;
        }
      });
    });
  });

  // Export functions
  function exportToCSV() {
    const table = document.getElementById('transactionTable');
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    for (let i = 0; i < rows.length; i++) {
      const row = [], cols = rows[i].querySelectorAll('td, th');
      
      for (let j = 0; j < cols.length; j++) {
        let text = cols[j].innerText;
        // Handle screenshot column
        if (j === 6 && cols[j].querySelector('img')) {
          text = 'Screenshot Available';
        }
        row.push('"' + text.replace(/"/g, '""') + '"');
      }
      csv.push(row.join(','));
    }
    
    downloadCSV(csv.join('\n'), 'transactions.csv');
    showToast('success', 'Export Successful', 'Transactions exported to CSV successfully!');
  }

  function exportToExcel() {
    const table = document.getElementById('transactionTable');
    let html = `
      <html xmlns:x="urn:schemas-microsoft-com:office:excel">
      <head>
        <meta charset="UTF-8">
        <style>
          table { border-collapse: collapse; width: 100%; }
          th { background-color: #f2f2f2; font-weight: bold; }
          th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        </style>
      </head>
      <body>
        <h2>Transactions Export - {{ now()->format('Y-m-d') }}</h2>
        ${table.outerHTML}
      </body>
      </html>
    `;
    
    const blob = new Blob([html], {type: 'application/vnd.ms-excel'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'transactions.xls';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    showToast('success', 'Export Successful', 'Transactions exported to Excel successfully!');
  }

  function downloadCSV(csv, filename) {
    const blob = new Blob([csv], {type: 'text/csv'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  }

  // Date filter functionality
  document.getElementById('dateFilter').addEventListener('change', function() {
    const filterValue = this.value;
    const rows = document.querySelectorAll('#transactionTable tbody tr');
    
    rows.forEach(row => {
      const dateText = row.querySelector('td:nth-child(6)').textContent;
      const rowDate = new Date(dateText);
      let showRow = true;
      
      if (filterValue !== 'all') {
        const now = new Date();
        if (filterValue === 'today') {
          showRow = rowDate.toDateString() === now.toDateString();
        } else if (filterValue === 'this_week') {
          const startOfWeek = new Date(now);
          startOfWeek.setDate(now.getDate() - now.getDay());
          startOfWeek.setHours(0, 0, 0, 0);
          const endOfWeek = new Date(startOfWeek);
          endOfWeek.setDate(startOfWeek.getDate() + 6);
          endOfWeek.setHours(23, 59, 59, 999);
          showRow = rowDate >= startOfWeek && rowDate <= endOfWeek;
        } else if (filterValue === 'this_month') {
          const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
          const endOfMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59, 999);
          showRow = rowDate >= startOfMonth && rowDate <= endOfMonth;
        }
      }
      
      row.style.display = showRow ? '' : 'none';
    });
  });

  // Search functionality
  document.getElementById('searchInput').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const rows = document.querySelectorAll('#transactionTable tbody tr');
    
    rows.forEach(row => {
      const rowText = row.textContent.toLowerCase();
      row.style.display = rowText.includes(searchText) ? '' : 'none';
    });
  });

  // Status filter functionality
  document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    const rows = document.querySelectorAll('#transactionTable tbody tr');
    
    rows.forEach(row => {
      const rowStatus = row.getAttribute('data-status');
      const showRow = status === 'all' || rowStatus === status;
      row.style.display = showRow ? '' : 'none';
    });
  });
</script>

@endsection
