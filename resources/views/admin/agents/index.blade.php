@extends("layout.master")

@section("title", "Agents Management")

@section("content")
	<style>
		.agents-container {
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

		.add-agent-btn {
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

		.add-agent-btn:hover {
			transform: translateY(-2px);
			background: linear-gradient(135deg, #d81b60, #e91e63);
		}

		.agents-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			border-radius: 10px;
			overflow: hidden;
		}

		.agents-table th,
		.agents-table td {
			padding: 12px 15px;
			text-align: left;
		}

		.agents-table th {
			background: #fde1eb;
			color: #d81b60;
			font-size: 15px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.agents-table tr:nth-child(even) {
			background-color: #fff6fa;
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

		/* Modal Styles */
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			align-items: center;
			justify-content: center;
			padding: 20px;
			box-sizing: border-box;
		}

		.modal-content {
			background-color: #fff;
			padding: 30px;
			border-radius: 12px;
			box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
			position: relative;
			max-height: 90vh;
			overflow-y: auto;
			-webkit-overflow-scrolling: touch;
		}

		.close-btn {
			position: absolute;
			top: 15px;
			right: 20px;
			font-size: 28px;
			font-weight: bold;
			color: #aaa;
			cursor: pointer;
			width: 40px;
			height: 40px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			transition: background-color 0.3s ease;
		}

		.close-btn:hover {
			color: #000;
			background-color: #f0f0f0;
		}

		/* Touch-friendly modal improvements */
		.modal-content::-webkit-scrollbar {
			width: 6px;
		}

		.modal-content::-webkit-scrollbar-track {
			background: #f1f1f1;
			border-radius: 3px;
		}

		.modal-content::-webkit-scrollbar-thumb {
			background: #c1c1c1;
			border-radius: 3px;
		}

		.modal-content::-webkit-scrollbar-thumb:hover {
			background: #a8a8a8;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-group label {
			display: block;
			margin-bottom: 8px;
			font-weight: 600;
			color: #d81b60;
		}

		.form-group input,
		.form-group select {
			width: 100%;
			padding: 12px;
			border: 1px solid #ddd;
			border-radius: 8px;
			font-size: 14px;
			min-height: 44px; /* Minimum touch target size */
			box-sizing: border-box;
		}

		.form-group input:focus,
		.form-group select:focus {
			outline: none;
			border-color: #e91e63;
			box-shadow: 0 0 0 2px rgba(233, 30, 99, 0.2);
		}

		/* Touch-friendly buttons */
		.btn-cancel,
		.btn-submit {
			padding: 12px 24px;
			border: none;
			border-radius: 8px;
			color: white;
			cursor: pointer;
			font-size: 14px;
			min-height: 44px; /* Minimum touch target size */
			transition: all 0.3s ease;
		}

		.btn-cancel {
			background: #6c757d;
		}

		.btn-submit {
			background: linear-gradient(135deg, #e91e63, #ff4081);
		}

		.btn-cancel:hover,
		.btn-submit:hover {
			transform: translateY(-1px);
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		}

		.btn-cancel:active,
		.btn-submit:active {
			transform: translateY(0);
		}

		/* Mobile Cards Layout */
		.agents-cards {
			display: none;
		}

		.agent-card {
			background: white;
			border-radius: 12px;
			padding: 20px;
			margin-bottom: 15px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			border-left: 4px solid #e91e63;
		}

		.agent-card-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 15px;
			flex-wrap: wrap;
			gap: 10px;
		}

		.agent-name {
			font-size: 18px;
			font-weight: bold;
			color: #d81b60;
			margin: 0;
		}

		.agent-status {
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: bold;
		}

		.agent-details {
			display: grid;
			gap: 10px;
			margin-bottom: 15px;
		}

		.agent-detail {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 14px;
		}

		.agent-detail i {
			color: #e91e63;
			width: 16px;
		}

		.agent-actions {
			display: flex;
			gap: 10px;
			justify-content: flex-end;
			flex-wrap: wrap;
		}

		@media (max-width: 768px) {
			.agents-container {
				padding: 15px;
				margin-left: 0;
			}

			.agents-table {
				display: none;
			}

			.agents-cards {
				display: block;
			}

			.agent-card {
				padding: 15px;
			}

			.agent-name {
				font-size: 16px;
			}

			.agent-detail {
				font-size: 13px;
			}

			.action-buttons {
				flex-direction: column;
				gap: 2px;
			}

			.btn-edit,
			.btn-delete {
				font-size: 12px;
				padding: 4px 8px;
			}

			.modal-content {
				width: 95%;
				margin: 2% auto;
				padding: 15px;
			}

			.form-group input,
			.form-group select {
				padding: 10px;
				font-size: 13px;
			}

			.btn-cancel,
			.btn-submit {
				padding: 10px 20px;
				font-size: 13px;
			}
		}

		@media (max-width: 576px) {
			.agents-container {
				padding: 10px;
			}

			.section-title {
				font-size: 24px;
				margin-bottom: 15px;
			}

			.add-agent-btn {
				padding: 10px 20px;
				font-size: 14px;
				margin: 15px auto;
			}

			.agent-card {
				padding: 12px;
			}

			.agent-card-header {
				flex-direction: column;
				align-items: flex-start;
				gap: 8px;
			}

			.agent-actions {
				justify-content: stretch;
			}

			.agent-actions .btn-edit,
			.agent-actions .btn-delete {
				flex: 1;
				text-align: center;
			}

			.modal-content {
				width: 98%;
				margin: 1% auto;
				padding: 12px;
			}

			.form-group {
				margin-bottom: 15px;
			}

			.form-group label {
				font-size: 14px;
				margin-bottom: 6px;
			}
		}

		@media (max-width: 400px) {
			.agent-details {
				grid-template-columns: 1fr;
			}

			.agent-actions {
				flex-direction: column;
			}

			.agent-actions .btn-edit,
			.agent-actions .btn-delete {
				width: 100%;
			}
		}
	</style>

	<!-- Toast Container -->
	<div class="toast-container" id="toastContainer"></div>

	<!-- CSRF Token for AJAX -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="agents-container">
		<div class="header">
			<div>
				<h2 class="section-title">👤 Agents Management</h2>
			</div>
			<div><button type="button" class="add-agent-btn" onclick="openCreateModal()">+ Add New Agent</button></div>
		</div>

		<table class="agents-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@forelse($agents as $agent)
					<tr>
						<td><strong>{{ $agent->name }}</strong></td>
						<td>{{ $agent->email }}</td>
						<td>{{ $agent->phone ?? 'N/A' }}</td>
						<td>
							<span class="status-badge status-{{ $agent->status }}">
								{{ $agent->status === "active" ? "Active" : "Inactive" }}
							</span>
						</td>
						<td>
							<div class="action-buttons">
								<button type="button" class="btn-edit"
									onclick="openEditModal({{ $agent->id }}, '{{ $agent->name }}', '{{ $agent->email }}', '{{ $agent->phone }}', '{{ $agent->status }}')">Edit</button>
								<form action="{{ route("admin.agents.destroy", $agent->id) }}" method="POST" style="display: inline;">
									@csrf
									@method("DELETE")
									<button type="submit" class="btn-delete"
										onclick="return confirm('Are you sure you want to delete this agent?')">Delete</button>
								</form>
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" style="text-align: center;">No agents found.</td>
					</tr>
				@endforelse
			</tbody>
		</table>

		<!-- Mobile Cards Layout -->
		<div class="agents-cards">
			@forelse($agents as $agent)
				<div class="agent-card">
					<div class="agent-card-header">
						<h3 class="agent-name">{{ $agent->name }}</h3>
						<span class="status-badge status-{{ $agent->status }} agent-status">
							{{ $agent->status === "active" ? "Active" : "Inactive" }}
						</span>
					</div>

					<div class="agent-details">
						<div class="agent-detail">
							<i class="fas fa-envelope"></i>
							<span>{{ $agent->email }}</span>
						</div>
						<div class="agent-detail">
							<i class="fas fa-phone"></i>
							<span>{{ $agent->phone ?? 'N/A' }}</span>
						</div>
					</div>

					<div class="agent-actions">
						<button type="button" class="btn-edit"
							onclick="openEditModal({{ $agent->id }}, '{{ $agent->name }}', '{{ $agent->email }}', '{{ $agent->phone }}', '{{ $agent->status }}')">Edit</button>
						<form action="{{ route("admin.agents.destroy", $agent->id) }}" method="POST" style="display: inline;">
							@csrf
							@method("DELETE")
							<button type="submit" class="btn-delete"
								onclick="return confirm('Are you sure you want to delete this agent?')">Delete</button>
						</form>
					</div>
				</div>
			@empty
				<div class="agent-card" style="text-align: center;">
					<p>No agents found.</p>
				</div>
			@endforelse
		</div>
	</div>

	<!-- Edit Agent Modal -->
	<div id="editModal" class="modal" style="display: none;">
		<div class="modal-content" style="width: 500px; max-height: 80vh; overflow-y: auto;">
			<span class="close-btn" onclick="closeEditModal()">&times;</span>
			<h2 style="color: #e91e63; font-family: 'Pacifico', cursive; text-align: center; margin-bottom: 20px;">✏️ Edit Agent</h2>

			<form id="editAgentForm" method="POST">
				@csrf
				@method("PUT")

				<input type="hidden" id="edit_agent_id" name="id">

				<div class="form-group">
					<label for="edit_name">Name *</label>
					<input type="text" id="edit_name" name="name" required>
				</div>

				<div class="form-group">
					<label for="edit_email">Email *</label>
					<input type="email" id="edit_email" name="email" required>
				</div>

				<div class="form-group">
					<label for="edit_phone">Phone</label>
					<input type="text" id="edit_phone" name="phone" placeholder="Optional">
				</div>

				<div class="form-group">
					<label for="edit_password">Password (leave blank to keep current)</label>
					<input type="password" id="edit_password" name="password" placeholder="Enter new password">
				</div>

				<div class="form-group">
					<label for="edit_status">Status *</label>
					<select id="edit_status" name="status" required>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>

				<div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
					<button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
					<button type="submit" class="btn-submit">💾 Update Agent</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Create Agent Modal -->
	<div id="createModal" class="modal" style="display: none;">
		<div class="modal-content" style="width: 500px; max-height: 80vh; overflow-y: auto;">
			<span class="close-btn" onclick="closeCreateModal()">&times;</span>
			<h2 style="color: #e91e63; font-family: 'Pacifico', cursive; text-align: center; margin-bottom: 20px;">✨ Create New Agent</h2>

			<form id="createAgentForm" action="{{ route("admin.agents.store") }}" method="POST">
				@csrf

				<div class="form-group">
					<label for="create_name">Name *</label>
					<input type="text" id="create_name" name="name" required>
				</div>

				<div class="form-group">
					<label for="create_email">Email *</label>
					<input type="email" id="create_email" name="email" required>
				</div>

				<div class="form-group">
					<label for="create_phone">Phone</label>
					<input type="text" id="create_phone" name="phone" placeholder="Optional">
				</div>

				<div class="form-group">
					<label for="create_password">Password *</label>
					<input type="password" id="create_password" name="password" required placeholder="Enter password">
				</div>

				<div class="form-group">
					<label for="create_status">Status *</label>
					<select id="create_status" name="status" required>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>

				<div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
					<button type="button" class="btn-cancel" onclick="closeCreateModal()">Cancel</button>
					<button type="submit" class="btn-submit">💾 Create Agent</button>
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
			document.getElementById('createAgentForm').reset();
		}

		function openEditModal(id, name, email, phone, status) {
			document.getElementById('edit_agent_id').value = id;
			document.getElementById('edit_name').value = name;
			document.getElementById('edit_email').value = email;
			document.getElementById('edit_phone').value = phone || '';
			document.getElementById('edit_status').value = status;

			// Set up the form action
			document.getElementById('editAgentForm').action = `/admin/agents/${id}`;

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
		document.getElementById('createAgentForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Basic validation
			const name = document.getElementById('create_name').value;
			const email = document.getElementById('create_email').value;
			const password = document.getElementById('create_password').value;

			if (!name || !email || !password) {
				showToast('error', 'Error', 'Please fill all required fields');
				return;
			}

			this.submit();
		});

		// Handle edit form submission
		document.getElementById('editAgentForm').addEventListener('submit', function(e) {
			e.preventDefault();

			// Basic validation
			const name = document.getElementById('edit_name').value;
			const email = document.getElementById('edit_email').value;

			if (!name || !email) {
				showToast('error', 'Error', 'Please fill all required fields');
				return;
			}

			this.submit();
		});
	</script>
@endsection
