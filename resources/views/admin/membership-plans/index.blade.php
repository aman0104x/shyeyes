@extends("layout.master")

@section("title", "Membership Plans Management")

@section("content")
	<style>
		.membership-plans-container {
			padding: 30px;
			background: #f7d2e6c4;
			border-radius: 12px;
			box-shadow: 0 0 40px rgba(53, 31, 31, 0.05);
			height: 100%;
			margin: 0 auto;
			font-family: 'Segoe UI', sans-serif;
		}

		.section-title {
			font-size: 28px;
			color: #ff4081;
			margin-bottom: 20px;
			font-family: 'Pacifico', cursive;
			text-align: center;
		}

		.add-plan-btn {
			display: block;
			margin: 20px auto;
			background: linear-gradient(135deg, #e91e63, #ff4081);
			color: #fff;
			border: none;
			padding: 12px 25px;
			border-radius: 50px;
			font-size: 15px;
			cursor: pointer;
			transition: 0.3s;
			box-shadow: 0 5px 15px rgba(233, 30, 99, 0.3);
		}

		.add-plan-btn:hover {
			transform: translateY(-2px);
			background: linear-gradient(135deg, #d81b60, #e91e63);
		}

		.plans-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			border-radius: 10px;
			overflow: hidden;
		}

		.plans-table th,
		.plans-table td {
			padding: 12px 15px;
			text-align: left;
		}

		.plans-table th {
			background: #fde1eb;
			color: #d81b60;
			font-size: 15px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.plans-table tr:nth-child(even) {
			background-color: #fff6fa;
		}

		.plans-table td ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}

		.plans-table td ul li {
			margin: 5px 0;
			padding-left: 22px;
			position: relative;
			color: #444;
		}

		.plans-table td ul li::before {
			content: "❤";
			color: #e91e63;
			position: absolute;
			left: 0;
			top: 0;
			font-size: 14px;
		}

		.action-buttons {
			display: flex;
			gap: 5px;
		}

		.btn-edit {
			background: #ff9800;
			color: white;
			padding: 6px 12px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			transition: 0.3s;
		}

		.btn-edit:hover {
			background: #e65100;
		}

		.btn-delete {
			background: #f44336;
			color: white;
			padding: 6px 12px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			transition: 0.3s;
		}

		.btn-delete:hover {
			background: #b71c1c;
		}

		.status-badge {
			padding: 5px 10px;
			border-radius: 12px;
			font-weight: bold;
			display: inline-block;
			min-width: 60px;
			text-align: center;
		}

		.status-active {
			background-color: #52c41a;
			color: #fff;
		}

		.status-inactive {
			background-color: #ff4d4f;
			color: #fff;
		}

		/* Toast Notification Styles */
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

		/* Mobile Card View */
		.plans-cards {
			display: none;
			flex-direction: column;
			gap: 15px;
			margin-top: 20px;
		}

		.plan-card {
			background: white;
			border-radius: 12px;
			padding: 20px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			border-left: 4px solid #e91e63;
		}

		.plan-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 15px;
			padding-bottom: 10px;
			border-bottom: 1px solid #f0f0f0;
		}

		.plan-name {
			font-size: 18px;
			font-weight: bold;
			color: #d81b60;
			margin: 0;
		}

		.plan-status {
			font-size: 12px;
		}

		.plan-details {
			display: grid;
			gap: 10px;
			margin-bottom: 15px;
		}

		.plan-price {
			font-size: 16px;
			color: #333;
		}

		.plan-price strong {
			color: #e91e63;
		}

		.plan-features {
			margin: 0;
			padding: 0;
			list-style: none;
		}

		.plan-features li {
			margin: 5px 0;
			padding-left: 22px;
			position: relative;
			color: #444;
			font-size: 14px;
		}

		.plan-features li::before {
			content: "❤";
			color: #e91e63;
			position: absolute;
			left: 0;
			top: 0;
			font-size: 12px;
		}

		.plan-actions {
			display: flex;
			gap: 8px;
			justify-content: flex-end;
			padding-top: 15px;
			border-top: 1px solid #f0f0f0;
		}

		/* Modal Styles */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			justify-content: center;
			align-items: center;
			padding: 20px;
			box-sizing: border-box;
		}

		.modal-content {
			background: white;
			border-radius: 12px;
			overflow: hidden;
			width: 100%;
			max-width: 600px;
			max-height: 90vh;
			overflow-y: auto;
			position: relative;
		}

		.close-btn {
			position: absolute;
			top: 15px;
			right: 20px;
			font-size: 28px;
			font-weight: bold;
			color: #aaa;
			cursor: pointer;
			z-index: 10;
		}

		.close-btn:hover {
			color: #000;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			margin-bottom: 5px;
			font-weight: 600;
			color: #333;
		}

		.form-group input,
		.form-group select {
			width: 100%;
			padding: 12px;
			border: 1px solid #ddd;
			border-radius: 8px;
			font-size: 14px;
			box-sizing: border-box;
		}

		.feature-checkbox {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 10px;
			margin-top: 10px;
		}

		.feature-checkbox label {
			display: flex;
			align-items: center;
			background: #fff0f6;
			padding: 10px 15px;
			border-radius: 20px;
			cursor: pointer;
			color: #d81b60;
			font-size: 14px;
			border: 1px solid #f5c0d7;
			margin: 0;
			font-weight: normal;
		}

		.feature-checkbox input {
			width: auto;
			margin-right: 8px;
		}

		.modal-actions {
			display: flex;
			gap: 10px;
			justify-content: flex-end;
			margin-top: 20px;
			flex-wrap: wrap;
		}

		.btn-cancel {
			padding: 12px 20px;
			border: none;
			border-radius: 8px;
			background: #6c757d;
			color: white;
			cursor: pointer;
			font-size: 14px;
		}

		.btn-submit {
			padding: 12px 20px;
			border: none;
			border-radius: 8px;
			background: linear-gradient(135deg, #e91e63, #ff4081);
			color: white;
			cursor: pointer;
			font-size: 14px;
		}

		/* Responsive Styles */
		@media (max-width: 1024px) {
			.membership-plans-container {
				padding: 20px;
			}

			.plans-table {
				font-size: 14px;
			}

			.plans-table th,
			.plans-table td {
				padding: 10px 12px;
			}
		}

		@media (max-width: 768px) {
			.membership-plans-container {
				padding: 15px;
				margin-left: 0;
			}

			.section-title {
				font-size: 24px;
			}

			.plans-table {
				display: none;
			}

			.plans-cards {
				display: flex;
			}

			.plan-card {
				padding: 15px;
			}

			.plan-name {
				font-size: 16px;
			}

			.plan-price {
				font-size: 14px;
			}

			.modal-content {
				margin: 10px;
				max-height: 85vh;
			}

			.feature-checkbox {
				grid-template-columns: 1fr;
			}

			.modal-actions {
				flex-direction: column;
			}

			.btn-cancel,
			.btn-submit {
				width: 100%;
			}
		}

		@media (max-width: 480px) {
			.membership-plans-container {
				padding: 10px;
			}

			.section-title {
				font-size: 20px;
			}

			.add-plan-btn {
				padding: 10px 20px;
				font-size: 14px;
			}

			.plan-card {
				padding: 12px;
			}

			.plan-header {
				flex-direction: column;
				align-items: flex-start;
				gap: 8px;
			}

			.plan-actions {
				flex-direction: column;
			}

			.btn-edit,
			.btn-delete {
				width: 100%;
				text-align: center;
			}
		}
	</style>

	<!-- Toast Container -->
	<div class="toast-container" id="toastContainer"></div>

	<!-- CSRF Token for AJAX -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="membership-plans-container">
		<div class="header">
			<div>
				<h2 class="section-title">👑 Membership Plans Management</h2>
			</div>
			<div><button type="button" class="add-plan-btn" onclick="openCreateModal()">+ Add New Plan</button></div>
		</div>

		<table class="plans-table">
			<thead>
				<tr>
					<th>Plan Name</th>
					<th>Price (₹)</th>
					<th>Monthly Price (₹)</th>
					<th>Features</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@forelse($plans as $plan)
					<tr>
						<td><strong>{{ $plan->name }}</strong></td>
						<td>₹{{ number_format($plan->price, 2) }}</td>
						<td>₹{{ number_format($plan->monthly_price, 2) }}</td>
						<td>
							<ul>
								@foreach ($plan->features as $feature)
									<li>{{ $feature }}</li>
								@endforeach
							</ul>
						</td>
						<td>
							<span class="status-badge status-{{ $plan->status }}">
								{{ $plan->status === "active" ? "Active" : "Inactive" }}
							</span>
						</td>
						<td>
							<div class="action-buttons">
								<button type="button" class="btn-edit"
									onclick="openEditModal({{ $plan->id }}, '{{ $plan->name }}', {{ $plan->price }}, {{ $plan->monthly_price }}, {{ json_encode($plan->features) }}, '{{ $plan->status }}')">Edit</button>
								<form action="{{ route("admin.membership-plans.destroy", $plan->id) }}" method="POST" style="display: inline;">
									@csrf
									@method("DELETE")
									<button type="submit" class="btn-delete"
										onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
								</form>
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="6" style="text-align: center;">No membership plans found.</td>
					</tr>
				@endforelse
			</tbody>
		</table>

		<!-- Mobile Card View -->
		<div class="plans-cards">
			@forelse($plans as $plan)
				<div class="plan-card">
					<div class="plan-header">
						<h3 class="plan-name">{{ $plan->name }}</h3>
						<span class="status-badge status-{{ $plan->status }} plan-status">
							{{ $plan->status === "active" ? "Active" : "Inactive" }}
						</span>
					</div>
					<div class="plan-details">
						<div class="plan-price">
							<strong>Price:</strong> ₹{{ number_format($plan->price, 2) }}
						</div>
						<div class="plan-price">
							<strong>Monthly:</strong> ₹{{ number_format($plan->monthly_price, 2) }}
						</div>
						<div class="plan-features">
							<strong>Features:</strong>
							<ul>
								@foreach ($plan->features as $feature)
									<li>{{ $feature }}</li>
								@endforeach
							</ul>
						</div>
					</div>
					<div class="plan-actions">
						<button type="button" class="btn-edit"
							onclick="openEditModal({{ $plan->id }}, '{{ $plan->name }}', {{ $plan->price }}, {{ $plan->monthly_price }}, {{ json_encode($plan->features) }}, '{{ $plan->status }}')">Edit</button>
						<form action="{{ route("admin.membership-plans.destroy", $plan->id) }}" method="POST" style="display: inline;">
							@csrf
							@method("DELETE")
							<button type="submit" class="btn-delete"
								onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
						</form>
					</div>
				</div>
			@empty
				<div class="plan-card" style="text-align: center;">
					No membership plans found.
				</div>
			@endforelse
		</div>
	</div>

	<!-- Edit Plan Modal -->
	<div id="editModal" class="modal" style="display: none;">
		<div class="modal-content" style="width: 600px; max-height: 80vh; overflow-y: auto;">
			<span class="close-btn" onclick="closeEditModal()">&times;</span>
			<h2 style="color: #e91e63; font-family: 'Pacifico', cursive; text-align: center; margin-bottom: 20px;">✏️ Edit Plan
			</h2>

			<form id="editPlanForm" method="POST">
				@csrf
				@method("PUT")

				<input type="hidden" id="edit_plan_id" name="id">

				<div class="form-group">
					<label for="edit_name">Plan Name *</label>
					<input type="text" id="edit_name" name="name" required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
				</div>

				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
					<div class="form-group">
						<label for="edit_price">Price (₹) *</label>
						<input type="number" id="edit_price" name="price" step="0.01" min="0" required
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
					</div>

					<div class="form-group">
						<label for="edit_monthly_price">Monthly Price (₹) *</label>
						<input type="number" id="edit_monthly_price" name="monthly_price" step="0.01" min="0" required
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
					</div>
				</div>

				<div class="form-group">
					<label>Features *</label>
					<div class="feature-checkbox"
						style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; margin-top: 10px;">
						@foreach ($availableFeatures as $feature)
							<label
								style="display: flex; align-items: center; background: #fff0f6; padding: 8px 12px; border-radius: 20px; cursor: pointer; color: #d81b60; font-size: 14px; border: 1px solid #f5c0d7;">
								<input type="checkbox" name="features[]" value="{{ $feature }}" class="edit-feature"
									style="margin-right: 8px;">
								{{ $feature }}
							</label>
						@endforeach
					</div>
				</div>

				<div class="form-group">
					<label for="edit_status">Status *</label>
					<select id="edit_status" name="status" required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>

				<div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
					<button type="button" class="btn-cancel" onclick="closeEditModal()"
						style="padding: 10px 20px; border: none; border-radius: 8px; background: #6c757d; color: white; cursor: pointer;">Cancel</button>
					<button type="submit" class="btn-submit"
						style="padding: 10px 20px; border: none; border-radius: 8px; background: linear-gradient(135deg, #e91e63, #ff4081); color: white; cursor: pointer;">💾
						Update Plan</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Create Plan Modal -->
	<div id="createModal" class="modal" style="display: none;">
		<div class="modal-content" style="width: 600px; max-height: 80vh; overflow-y: auto;">
			<span class="close-btn" onclick="closeCreateModal()">&times;</span>
			<h2 style="color: #e91e63; font-family: 'Pacifico', cursive; text-align: center; margin-bottom: 20px;">✨ Create New
				Plan</h2>

			<form id="createPlanForm" action="{{ route("admin.membership-plans.store") }}" method="POST">
				@csrf

				<div class="form-group">
					<label for="create_name">Plan Name *</label>
					<input type="text" id="create_name" name="name" required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
				</div>

				<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
					<div class="form-group">
						<label for="create_price">Price (₹) *</label>
						<input type="number" id="create_price" name="price" step="0.01" min="0" required
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
					</div>

					<div class="form-group">
						<label for="create_monthly_price">Monthly Price (₹) *</label>
						<input type="number" id="create_monthly_price" name="monthly_price" step="0.01" min="0" required
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
					</div>
				</div>

				<div class="form-group">
					<label>Features *</label>
					<div class="feature-checkbox"
						style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; margin-top: 10px;">
						@foreach ($availableFeatures as $feature)
							<label
								style="display: flex; align-items: center; background: #fff0f6; padding: 8px 12px; border-radius: 20px; cursor: pointer; color: #d81b60; font-size: 14px; border: 1px solid #f5c0d7;">
								<input type="checkbox" name="features[]" value="{{ $feature }}" style="margin-right: 8px;">
								{{ $feature }}
							</label>
						@endforeach
					</div>
				</div>

				<div class="form-group">
					<label for="create_status">Status *</label>
					<select id="create_status" name="status" required
						style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>

				<div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
					<button type="button" class="btn-cancel" onclick="closeCreateModal()"
						style="padding: 10px 20px; border: none; border-radius: 8px; background: #6c757d; color: white; cursor: pointer;">Cancel</button>
					<button type="submit" class="btn-submit"
						style="padding: 10px 20px; border: none; border-radius: 8px; background: linear-gradient(135deg, #e91e63, #ff4081); color: white; cursor: pointer;">💾
						Create Plan</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		// Toast Notification Functions
		function showToast(type, title, message, duration = 3000) {
			const container = document.getElementById('toastContainer');
			const toast = document.createElement('div');
			toast.className = `toast toast-${type}`;

			const icons = {
				success: '✅',
				error: '❌'
			};

			toast.innerHTML = `
                <div class="toast-header">
                    <span class="toast-title">${icons[type]} ${title}</span>
                    <button class="toast-close" onclick="closeToast(this.parentElement.parentElement)">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;

			container.appendChild(toast);

			// Trigger animation
			setTimeout(() => toast.classList.add('show'), 100);

			// Auto close after duration
			setTimeout(() => closeToast(toast), duration);
		}

		function closeToast(toast) {
			toast.classList.remove('show');
			setTimeout(() => {
				if (toast.parentElement) {
					toast.parentElement.removeChild(toast);
				}
			}, 300);
		}

		// Modal Functions
		function openCreateModal() {
			document.getElementById('createModal').style.display = 'flex';
		}

		function closeCreateModal() {
			document.getElementById('createModal').style.display = 'none';
			document.getElementById('createPlanForm').reset();
		}

		function openEditModal(id, name, price, monthlyPrice, features, status) {
			document.getElementById('edit_plan_id').value = id;
			document.getElementById('edit_name').value = name;
			document.getElementById('edit_price').value = price;
			document.getElementById('edit_monthly_price').value = monthlyPrice;
			document.getElementById('edit_status').value = status;

			// Set up the form action
			document.getElementById('editPlanForm').action = `/admin/membership-plans/${id}`;

			// Clear all checkboxes first
			document.querySelectorAll('.edit-feature').forEach(checkbox => {
				checkbox.checked = false;
			});

			// Check the features that are in the plan
			features.forEach(feature => {
				document.querySelectorAll('.edit-feature').forEach(checkbox => {
					if (checkbox.value === feature) {
						checkbox.checked = true;
					}
				});
			});

			document.getElementById('editModal').style.display = 'flex';
		}

		function closeEditModal() {
			document.getElementById('editModal').style.display = 'none';
		}

		// Close modals when clicking outside
		window.addEventListener('click', function(event) {
			const createModal = document.getElementById('createModal');
			const editModal = document.getElementById('editModal');

			if (event.target === createModal) {
				closeCreateModal();
			}
			if (event.target === editModal) {
				closeEditModal();
			}
		});

		// Show success message if redirected with success
		@if (session("success"))
			showToast('success', 'Success', '{{ session("success") }}');
		@endif

		@if (session("error"))
			showToast('error', 'Error', '{{ session("error") }}');
		@endif

		// Handle form submission
		document.getElementById('createPlanForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Basic validation
			const name = document.getElementById('create_name').value;
			const price = document.getElementById('create_price').value;
			const monthlyPrice = document.getElementById('create_monthly_price').value;
			const features = document.querySelectorAll('input[name="features[]"]:checked');

			if (!name || !price || !monthlyPrice || features.length === 0) {
				showToast('error', 'Error', 'Please fill all required fields');
				return;
			}

			this.submit();
		});

		// Handle edit form submission
		document.getElementById('editPlanForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Basic validation
			const name = document.getElementById('edit_name').value;
			const price = document.getElementById('edit_price').value;
			const monthlyPrice = document.getElementById('edit_monthly_price').value;
			const features = document.querySelectorAll('.edit-feature:checked');

			if (!name || !price || !monthlyPrice || features.length === 0) {
				showToast('error', 'Error', 'Please fill all required fields');
				return;
			}

			this.submit();
		});
	</script>
@endsection
