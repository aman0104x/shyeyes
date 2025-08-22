@extends("layout.master") {{-- Your admin master layout --}}

@section("title", "User Management")

@section("content")
	<style>
		/* ===== Improved Layout Styles ===== */
		.user-management-um {
			overflow-x: auto;
			padding: 30px;
			background: #f7d2e6c4;
			border-radius: 12px;
			box-shadow: 0 0 40px rgba(53, 31, 31, 0.05);
			height: 100%;
			/* max-width: 1200px; */
			margin: 0 auto;
			font-family: 'Segoe UI', sans-serif;
		}

		.section-title-um {
			font-size: 28px;
			color: #ff4081;
			margin-bottom: 20px;
			font-family: 'Pacifico', cursive;
		}

		.top-bar-um {
			display: flex;
			justify-content: space-between;
			margin-bottom: 15px;
			flex-wrap: wrap;
			gap: 10px;
		}

		.search-box-um,
		.status-filter-um {
			padding: 10px 15px;
			border: 1px solid #ccc;
			border-radius: 8px;
			box-sizing: border-box;
		}

		.search-box-um {
			width: 250px;
		}

		.status-filter-um {
			width: 150px;
		}

		.user-table-um {
			width: 100%;
			border-collapse: collapse;
			text-align: center;
			min-width: 700px;
		}

		.user-table-um th,
		.user-table-um td {
			padding: 19px 12px;
			border-bottom: 1px solid #eee;
			white-space: nowrap;
		}

		/* Fix for long email addresses */
		.email-cell {
			max-width: 200px;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		/* Responsive table cell widths */
		.user-table-um th:nth-child(3),
		.user-table-um td:nth-child(3) {
			max-width: 220px;
			min-width: 180px;
		}

		/* Ensure action buttons stay within cell */
		.user-table-um td:last-child {
			min-width: 350px;
			max-width: 400px;
			white-space: normal;
			text-align: center;
			vertical-align: middle;
			overflow: visible;
		}

		/* Proper button alignment */
		.btn-um {
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
			.email-cell {
				max-width: 150px;
			}

			.user-table-um td:last-child {
				min-width: auto;
				max-width: 280px;
			}

			.action-buttons {
				gap: 2px;
			}

			.btn-um {
				padding: 5px 8px;
				font-size: 12px;
				min-width: 60px;
			}
		}

		@media (max-width: 992px) {
			.email-cell {
				max-width: 120px;
				font-size: 12px;
			}

			.user-table-um td:last-child {
				min-width: auto;
				max-width: 250px;
			}

			.action-buttons {
				flex-direction: row;
				flex-wrap: wrap;
				gap: 2px;
			}

			.btn-um {
				padding: 4px 6px;
				font-size: 11px;
				min-width: 55px;
				margin: 1px;
			}
		}

		@media (max-width: 768px) {
			.email-cell {
				max-width: 100px;
				font-size: 11px;
			}

			.user-table-um td:last-child {
				min-width: auto;
				max-width: 200px;
			}

			.action-buttons {
				flex-direction: column;
				align-items: stretch;
				gap: 2px;
			}

			.btn-um {
				font-size: 11px;
				padding: 4px 6px;
				min-width: auto;
				width: 100%;
				margin: 1px 0;
			}
		}

		@media (max-width: 576px) {
			.user-table-um td:last-child {
				min-width: auto;
				max-width: 180px;
			}

			.action-buttons {
				flex-direction: column;
				gap: 1px;
			}

			.btn-um {
				font-size: 10px;
				padding: 3px 4px;
				min-width: auto;
				width: 100%;
			}
		}

		/* High zoom level fixes */
		@media (max-width: 480px) {
			.user-table-um td:last-child {
				min-width: auto;
				max-width: 150px;
			}

			.action-buttons {
				flex-direction: column;
				gap: 1px;
			}

			.btn-um {
				font-size: 9px;
				padding: 2px 3px;
				min-width: auto;
				width: 100%;
			}
		}

		.user-avatar-um {
			width: 40px;
			height: 40px;
			border-radius: 50%;
		}

		.status-um {
			font-weight: bold;
		}

		.status-um.Unblocked {
			color: green;
		}

		.status-um.inUnblocked {
			color: red;
		}

		.btn-um {
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

		.btn-um.view {
			background-color: #2315e6;
		}

		.btn-um.edit {
			background-color: #28a745;
		}

		.btn-um.delete {
			background-color: #e57373;
		}

		.btn-um.block {
			background-color: #dc3545;
		}

		.btn-um.unblock {
			background-color: #198754;
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
			max-width: 400px;
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

			.user-management-um {
				margin-left: 0;
				padding: 15px;
			}

			.top-bar-um {
				flex-direction: column;
				gap: 10px;
			}

			.search-box-um,
			.status-filter-um {
				width: 100%;
			}

			.user-table-um {
				min-width: unset;
				font-size: 13px;
			}

			.user-table-um th,
			.user-table-um td {
				padding: 8px 10px;
			}

			.btn-um {
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
	</style>

	<!-- Toast Container -->
	<div class="toast-container" id="toastContainer"></div>

	<!-- CSRF Token for AJAX -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<div class="user-management-um">
		<h2 class="section-title-um">👥 Manage Users</h2>
		<!-- Search & Filter -->
		<div class="top-bar-um">
			<div>
				<input type="text" placeholder="Search users..." class="search-box-um" id="searchInput" />
			</div>
			<div>
				<select class="status-filter-um" id="statusFilter">
					<option value="all">All Status</option>
					<option value="block">Block</option>
					<option value="unblock">Unblock</option>
				</select>
			</div>

			<!-- Users Table -->
			<table class="user-table-um" id="userTable">
				<thead>
					<tr>
						<th>Profile</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Gender</th>
						<th>Location</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@forelse($users as $user)
						<tr data-id="{{ $user->id }}" data-phone="{{ $user->phone ?? "N/A" }}"
							data-dob="{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format("d/m/Y") : "N/A" }}"
							data-age="{{ $user->age ?? "N/A" }}" data-about="{{ $user->about ?? "N/A" }}">
							<td>
								@php
									// Handle if DB has full path or just filename
									$imagePath = Str::startsWith($user->img, "uploads/")
									    ? asset($user->img)
									    : asset("uploads/users/" . $user->img);
								@endphp

								@if (!empty($user->img))
									<img src="{{ $imagePath }}" class="user-avatar-um" alt="Profile Image"
										onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->f_name . " " . $user->l_name) }}&size=40&background=ff4081&color=fff'">
								@else
									<img
										src="https://ui-avatars.com/api/?name={{ urlencode($user->f_name . " " . $user->l_name) }}&size=40&background=ff4081&color=fff"
										class="user-avatar-um" alt="Default Profile">
								@endif
							</td>

							<td class="name-cell">{{ $user->f_name ?? "" }} {{ $user->l_name ?? "" }}</td>
							<td class="email-cell" title="{{ $user->email }}">{{ $user->email }}</td>
							<td class="gender-cell">{{ $user->gender ? ucfirst($user->gender) : "N/A" }}</td>
							<td class="location-cell">{{ $user->location ?? "N/A" }}</td>
							<td>
								@php
									if ($user->status === "block") {
									    $statusColor = "#ff4d4f"; // Red
									    $statusText = "Blocked";
									} else {
									    $statusColor = "#52c41a"; // Green
									    $statusText = "Unblocked";
									}
								@endphp
								<span class="status-um {{ $user->status }}"
									style="background-color: {{ $statusColor }};
               color: #fff;
               padding: 5px 10px;
               border-radius: 12px;
               font-weight: bold;
               display: inline-block;
               min-width: 60px;
               text-align: center;">
									{{ $statusText }}
								</span>
							</td>

							<td>
								<div class="action-buttons">
									<button class="btn-um view">View</button>
									<button class="btn-um edit">Edit</button>

									@if ($user->status === "unblock")
										<button class="btn-um block" data-id="{{ $user->id }}">Block</button>
									@else
										<button class="btn-um unblock" data-id="{{ $user->id }}">Unblock</button>
									@endif

									<button type="button" class="btn-um delete"
										onclick="deleteUser({{ $user->id }}, '{{ $user->f_name }} {{ $user->l_name }}')">Delete</button>
								</div>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="7">No users found</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		{{-- View Modal --}}
		<div id="viewModal" class="modal">
			<div class="modal-content">
				<h3>👤 User Details</h3>

				<!-- Profile Image -->
				<div style="text-align: center; margin-bottom: 15px;">
					<img id="viewImage" src="" alt="User Image"
						style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc;"
						onerror="this.src='https://ui-avatars.com/api/?name=User&size=80&background=ff4081&color=fff'">
				</div>

				<div id="userDetails">
					<p><strong>Name:</strong> <span id="viewName"></span></p>
					<p><strong>Email:</strong> <span id="viewEmail"></span></p>
					<p><strong>Phone:</strong> <span id="viewPhone"></span></p>
					<p><strong>Gender:</strong> <span id="viewGender"></span></p>
					<p><strong>Location:</strong> <span id="viewLocation"></span>
					<p>
					<p><strong>Status:</strong> <span id="viewStatus"></span></p>
					<p><strong>Date of Birth:</strong> <span id="viewDob"></span></>
					<p><strong>Age:</strong> <span id="viewAge"></span></p>
					<p><strong>About:</strong> <span id="viewAbout"></span></p>
				</div>

				<!--<div class="modal-buttons">-->
				<!--	<button type="button" class="btn-cancel" onclick="closeViewModal()">Close</button>-->
				<!--</div>-->
			</div>
		</div>

		{{-- Edit Modal --}}
		<div id="editModal" class="modal">
			<div class="modal-content" style="max-width: 500px; max-height: 90vh; overflow-y: auto;">
				<h3 style="margin-bottom: 20px; color: #ff4081; font-family: 'Pacifico', cursive; text-align: center;">✏️ Edit User
				</h3>
				<form id="editForm" method="POST" enctype="multipart/form-data">
					@csrf @method("PUT")

					<!-- Profile Image Section -->
					<div style="text-align: center; margin-bottom: 20px;">
						<div style="position: relative; display: inline-block;">
							<img id="editImagePreview" src="" alt="Current Profile"
								style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #ff4081;">
							<label for="editImg"
								style="position: absolute; bottom: 0; right: 0; background: #ff4081; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px;">
								📷
							</label>
						</div>
						<input type="file" id="editImg" name="img" accept="image/*" style="display: none;">
					</div>

					<!-- Form Grid -->
					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">First
								Name</label>
							<input type="text" id="editFName" name="f_name" required
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
						</div>
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Last
								Name</label>
							<input type="text" id="editLName" name="l_name" required
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
						</div>
					</div>

					<div style="margin-top: 15px;">
						<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Email
							Address</label>
						<input type="email" id="editEmail" name="email" required
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
					</div>

					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Phone</label>
							<input type="tel" id="editPhone" name="phone"
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
						</div>
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Age</label>
							<input type="number" id="editAge" name="age" min="1" max="120"
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
						</div>
					</div>

					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Date of
								Birth</label>
							<input type="date" id="editDob" name="dob"
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
						</div>
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Gender</label>
							<select id="editGender" name="gender" required
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
								<option value="">Select Gender</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="other">Other</option>
							</select>
						</div>
					</div>

					<div style="margin-top: 15px;">
						<label
							style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Location</label>
						<input type="text" id="editLocation" name="location"
							style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;">
					</div>

					<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 15px;">
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">New
								Password</label>
							<input type="password" id="editPassword" name="password"
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
								placeholder="Leave blank to keep current password">
						</div>
						<div>
							<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">Confirm
								Password</label>
							<input type="password" id="editPasswordConfirmation" name="password_confirmation"
								style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; transition: border-color 0.3s;"
								placeholder="Confirm new password">
						</div>
					</div>

					<div style="margin-top: 15px;">
						<label style="display: block; margin-bottom: 5px; font-weight: 600; color: #333; font-size: 13px;">About</label>
						<textarea id="editAbout" name="about" rows="3"
						 style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical; transition: border-color 0.3s;"></textarea>
					</div>

					<!-- Status field removed from edit modal as requested -->

					<!-- Action Buttons -->
					<div
						style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee;">
						<button type="button" class="btn-cancel"
							style="padding: 10px 20px; border: none; border-radius: 8px; background: #6c757d; color: white; cursor: pointer; font-size: 14px; transition: background-color 0.3s;">
							Cancel
						</button>
						<button type="submit" class="btn-save"
							style="padding: 10px 20px; border: none; border-radius: 8px; background: #28a745; color: white; cursor: pointer; font-size: 14px; transition: background-color 0.3s;">
							💾 Save Changes
						</button>
					</div>
				</form>
			</div>
		</div>

		{{-- <script>
		// Toast Notification Functions
		function showToast(type, title, message, duration = 3000) {
			const container = document.getElementById('toastContainer');
			const toast = document.createElement('div');
			toast.className = `toast toast-${type}`;

			const icons = {
				success: '✅',
				error: '❌',
				warning: '⚠️'
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

		// Delete User Function with AJAX
		function deleteUser(userId, userName) {
			if (confirm(`Are you sure you want to delete ${userName}?`)) {
				const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

				// Use POST with _method parameter for Laravel compatibility
				fetch(`/admin/users/${userId}`, {
						method: 'POST',
						headers: {
							'X-CSRF-TOKEN': csrfToken,
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({
							_method: 'DELETE'
						})
					})
					.then(response => {
						console.log('Response status:', response.status);
						return response.text().then(text => {
							try {
								const data = JSON.parse(text);
								if (data.success) {
									showToast('success', 'User Deleted', 'User deleted successfully!');
									// Remove the row from the table
									const row = document.querySelector(`tr[data-id="${userId}"]`);
									if (row) {
										row.remove();
									}
								} else {
									throw new Error(data.message || 'Delete failed');
								}
							} catch (e) {
								// If response is not JSON, show the raw text
								console.error('Non-JSON response:', text);
								throw new Error('Server error: ' + text.substring(0, 100) + '...');
							}
						});
					})
					.catch(error => {
						console.error('Delete error:', error);
						showToast('error', 'Error', error.message || 'Error deleting user. Please try again.');
					});
			}
		}

		document.addEventListener('DOMContentLoaded', function() {
			const statusFilter = document.getElementById('statusFilter');
			const tbody = document.querySelector('#userTable tbody');
			const searchInput = document.getElementById('searchInput');

			function filterRows() {
				const filterValue = statusFilter.value.toLowerCase();
				const searchText = searchInput.value.toLowerCase();
				for (let row of tbody.rows) {
					const statusSpan = row.querySelector('.status-um');
					const nameCell = row.querySelector('.name-cell');
					let matchesStatus = filterValue === 'all' || statusSpan.classList.contains(filterValue);
					let matchesSearch = nameCell.textContent.toLowerCase().includes(searchText);
					row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
				}
			}

			statusFilter.addEventListener('change', filterRows);
			searchInput.addEventListener('input', filterRows);

			const viewModal = document.getElementById('viewModal');
			const editModal = document.getElementById('editModal');
			const editForm = document.getElementById('editForm');
			const editFName = document.getElementById('editFName');
			const editLName = document.getElementById('editLName');
			const editEmail = document.getElementById('editEmail');
			const editPhone = document.getElementById('editPhone');
			const editDob = document.getElementById('editDob');
			const editAge = document.getElementById('editAge');
			const editGender = document.getElementById('editGender');
			const editLocation = document.getElementById('editLocation');
			const editAbout = document.getElementById('editAbout');
			const editImg = document.getElementById('editImg');
			const editImagePreview = document.getElementById('editImagePreview');
			let currentEditRow = null;

			// View modal elements
			const viewName = document.getElementById('viewName');
			const viewEmail = document.getElementById('viewEmail');
			const viewPhone = document.getElementById('viewPhone');
			const viewGender = document.getElementById('viewGender');
			const viewLocation = document.getElementById('viewLocation');
			const viewStatus = document.getElementById('viewStatus');
			const viewDob = document.getElementById('viewDob');
			const viewAge = document.getElementById('viewAge');
			const viewAbout = document.getElementById('viewAbout');

			tbody.addEventListener('click', function(event) {
				const target = event.target;
				const row = target.closest('tr');
				if (!row) return;

				const nameCell = row.querySelector('.name-cell');
				const emailCell = row.querySelector('.email-cell');
				const genderCell = row.querySelector('.gender-cell');
				const locationCell = row.querySelector('.location-cell');
				const statusSpan = row.querySelector('.status-um');
				const userId = row.dataset.id;

				// View user
				if (target.classList.contains('view')) {
					const profileImg = row.querySelector('.user-avatar-um');
					const imgSrc = profileImg ? profileImg.src : '';

					viewName.textContent = nameCell.textContent;
					viewEmail.textContent = emailCell.textContent;
					viewPhone.textContent = row.dataset.phone || 'N/A';
					viewGender.textContent = genderCell.textContent;
					viewLocation.textContent = locationCell.textContent;
					viewStatus.textContent = statusSpan.textContent;
					viewDob.textContent = row.dataset.dob || 'N/A';
					viewAge.textContent = row.dataset.age || 'N/A';
					viewAbout.textContent = row.dataset.about || 'N/A';

					const viewImage = document.getElementById('viewImage');
					if (viewImage) {
						viewImage.src = imgSrc || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(
							nameCell.textContent) + '&size=80&background=ff4081&color=fff';
					}
					viewModal.style.display = 'flex';
				}

				// Edit user
				else if (target.classList.contains('edit')) {
					currentEditRow = row;

					const fullName = nameCell.textContent.trim();
					const nameParts = fullName.split(' ');
					editFName.value = nameParts[0] || '';
					editLName.value = nameParts.slice(1).join(' ') || '';
					editEmail.value = emailCell.textContent;
					editPhone.value = row.dataset.phone || '';

					const dobText = row.dataset.dob || '';
					if (dobText && dobText !== 'N/A') {
						const [day, month, year] = dobText.split('/');
						editDob.value = `${year}-${month.padStart(2,'0')}-${day.padStart(2,'0')}`;
					} else {
						editDob.value = '';
					}

					editAge.value = row.dataset.age || '';
					editGender.value = genderCell.textContent.toLowerCase() || '';
					editLocation.value = locationCell.textContent;
					editAbout.value = row.dataset.about || '';

					const profileImg = row.querySelector('.user-avatar-um');
					if (profileImg && profileImg.src) {
						editImagePreview.src = profileImg.src;
						editImagePreview.style.display = 'block';
					} else {
						editImagePreview.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(
							nameCell.textContent) + '&size=100&background=ff4081&color=fff';
					}

					editModal.style.display = 'flex';
				}

				// Block/Unblock user
				else if (target.classList.contains('block') || target.classList.contains('unblock')) {
					const newStatus = target.classList.contains('block') ? 'block' : 'unblock';
					if (confirm(
							`Are you sure you want to ${newStatus === 'block' ? 'Block' : 'Unblock'} this user?`
						)) {
						fetch(`/admin/users/${userId}/status`, {
								method: 'POST',
								headers: {
									'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
									'Accept': 'application/json',
									'Content-Type': 'application/json'
								},
								body: JSON.stringify({
									status: newStatus
								})
							})
							.then(res => res.json())
							.then(data => {
								if (data.success) {
									// Update badge UI
									if (newStatus === 'block') {
										statusSpan.textContent = 'Blocked';
										statusSpan.style.backgroundColor = '#ff4d4f';
									} else {
										statusSpan.textContent = 'Unblocked';
										statusSpan.style.backgroundColor = '#52c41a';
									}
									statusSpan.className = 'status-um ' + newStatus;

									// Update button
									target.textContent = newStatus === 'block' ? 'Unblock' : 'Block';
									target.classList.toggle('block');
									target.classList.toggle('unblock');

									showToast('success', 'Status Updated',
										`User ${newStatus === 'block' ? 'blocked' : 'unblocked'} successfully!`
									);
								} else {
									showToast('error', 'Update Failed', data.message ||
										'Failed to update status.');
								}
							})
							.catch(err => {
								console.error(err);
								showToast('error', 'Error', 'Error updating status. Please try again.');
							});
					}
				}
			});

			// Edit form submit
			// Edit form submit
			editForm.addEventListener('submit', function(e) {
				e.preventDefault();
				if (!currentEditRow) return;

				const formData = new FormData(editForm);
				const userId = currentEditRow.dataset.id;

				// Append method spoofing for PUT request
				formData.append('_method', 'PUT');

				fetch(`/admin/users/${userId}`, {
						method: 'POST', // Use POST with _method=PUT for Laravel
						body: formData,
						headers: {
							'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
							'Accept': 'application/json',
							'X-Requested-With': 'XMLHttpRequest' // Mark as AJAX request
						}
					})
					.then(response => {
						if (!response.ok) {
							throw new Error('Network response was not ok');
						}
						return response.json();
					})
					.then(data => {
						if (data.success) {
							// Update UI with new data
							const statusSpan = currentEditRow.querySelector('.status-um');
							// Status handling removed as the status field is no longer present

							// Update name, email, gender, location
							currentEditRow.querySelector('.name-cell').textContent =
								`${editFName.value.trim()} ${editLName.value.trim()}`;
							currentEditRow.querySelector('.email-cell').textContent = editEmail.value
								.trim();
							currentEditRow.querySelector('.gender-cell').textContent = editGender.value
								.charAt(0).toUpperCase() + editGender.value.slice(1);
							currentEditRow.querySelector('.location-cell').textContent = editLocation.value
								.trim();

							// Update data attributes for view modal
							currentEditRow.dataset.phone = editPhone.value;
							currentEditRow.dataset.dob = editDob.value ? new Date(editDob.value)
								.toLocaleDateString('en-GB') : 'N/A';
							currentEditRow.dataset.age = editAge.value || 'N/A';
							currentEditRow.dataset.about = editAbout.value || 'N/A';

							// Update profile image if changed
							if (data.user && data.user.img) {
								const profileImg = currentEditRow.querySelector('.user-avatar-um');
								if (profileImg) {
									const imagePath = data.user.img.startsWith('uploads/') ?
										`/${data.user.img}` :
										`/uploads/users/${data.user.img}`;
									profileImg.src = imagePath;
								}
							}

							editModal.style.display = 'none';
							currentEditRow = null;

							// Show success message
							showToast('success', 'User Updated', 'User updated successfully!');
						} else {
							showToast('error', 'Update Failed', data.message || 'Failed to update user.');
						}
					})
					.catch(err => {
						console.error('Error:', err);
						showToast('error', 'Error', 'Error updating user. Please try again.');
					});
			});


			// Cancel edit
			editModal.querySelector('.btn-cancel').addEventListener('click', () => {
				editModal.style.display = 'none';
				currentEditRow = null;
			});

			// Close modals when clicking outside
			window.addEventListener('click', e => {
				if (e.target === editModal) {
					editModal.style.display = 'none';
					currentEditRow = null;
				}
				if (e.target === viewModal) {
					viewModal.style.display = 'none';
				}
			});
		});
	</script> --}}
		<script>
			// Laravel routes with placeholders
			const routes = {
				deleteUser: "{{ route("admin.users.destroy", ":id") }}",
				updateUser: "{{ route("admin.users.update", ":id") }}",
				updateStatus: "{{ route("admin.users.status.update", ":id") }}"
			};

			// Toast Notification Functions
			function showToast(type, title, message, duration = 3000) {
				const container = document.getElementById('toastContainer');
				const toast = document.createElement('div');
				toast.className = `toast toast-${type}`;

				const icons = {
					success: '✅',
					error: '❌',
					warning: '⚠️'
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

			// Delete User Function with AJAX
			function deleteUser(userId, userName) {
				if (confirm(`Are you sure you want to delete ${userName}?`)) {
					const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

					fetch(routes.deleteUser.replace(':id', userId), {
							method: 'POST',
							headers: {
								'X-CSRF-TOKEN': csrfToken,
								'Accept': 'application/json',
								'Content-Type': 'application/json'
							},
							body: JSON.stringify({
								_method: 'DELETE'
							})
						})
						.then(response => response.text().then(text => {
							try {
								const data = JSON.parse(text);
								if (data.success) {
									showToast('success', 'User Deleted', 'User deleted successfully!');
									const row = document.querySelector(`tr[data-id="${userId}"]`);
									if (row) row.remove();
								} else {
									throw new Error(data.message || 'Delete failed');
								}
							} catch (e) {
								console.error('Non-JSON response:', text);
								throw new Error('Server error: ' + text.substring(0, 100) + '...');
							}
						}))
						.catch(error => {
							console.error('Delete error:', error);
							showToast('error', 'Error', error.message || 'Error deleting user. Please try again.');
						});
				}
			}

			document.addEventListener('DOMContentLoaded', function() {
				const statusFilter = document.getElementById('statusFilter');
				const tbody = document.querySelector('#userTable tbody');
				const searchInput = document.getElementById('searchInput');

				function filterRows() {
					const filterValue = statusFilter.value.toLowerCase();
					const searchText = searchInput.value.toLowerCase();
					for (let row of tbody.rows) {
						const statusSpan = row.querySelector('.status-um');
						const nameCell = row.querySelector('.name-cell');
						let matchesStatus = filterValue === 'all' || statusSpan.classList.contains(filterValue);
						let matchesSearch = nameCell.textContent.toLowerCase().includes(searchText);
						row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
					}
				}

				statusFilter.addEventListener('change', filterRows);
				searchInput.addEventListener('input', filterRows);

				const viewModal = document.getElementById('viewModal');
				const editModal = document.getElementById('editModal');
				const editForm = document.getElementById('editForm');
				const editFName = document.getElementById('editFName');
				const editLName = document.getElementById('editLName');
				const editEmail = document.getElementById('editEmail');
				const editPhone = document.getElementById('editPhone');
				const editDob = document.getElementById('editDob');
				const editAge = document.getElementById('editAge');
				const editGender = document.getElementById('editGender');
				const editLocation = document.getElementById('editLocation');
				const editAbout = document.getElementById('editAbout');
				const editImagePreview = document.getElementById('editImagePreview');
				let currentEditRow = null;

				// View modal elements
				const viewName = document.getElementById('viewName');
				const viewEmail = document.getElementById('viewEmail');
				const viewPhone = document.getElementById('viewPhone');
				const viewGender = document.getElementById('viewGender');
				const viewLocation = document.getElementById('viewLocation');
				const viewStatus = document.getElementById('viewStatus');
				const viewDob = document.getElementById('viewDob');
				const viewAge = document.getElementById('viewAge');
				const viewAbout = document.getElementById('viewAbout');

				tbody.addEventListener('click', function(event) {
					const target = event.target;
					const row = target.closest('tr');
					if (!row) return;

					const nameCell = row.querySelector('.name-cell');
					const emailCell = row.querySelector('.email-cell');
					const genderCell = row.querySelector('.gender-cell');
					const locationCell = row.querySelector('.location-cell');
					const statusSpan = row.querySelector('.status-um');
					const userId = row.dataset.id;

					// View user
					if (target.classList.contains('view')) {
						const profileImg = row.querySelector('.user-avatar-um');
						const imgSrc = profileImg ? profileImg.src : '';

						viewName.textContent = nameCell.textContent;
						viewEmail.textContent = emailCell.textContent;
						viewPhone.textContent = row.dataset.phone || 'N/A';
						viewGender.textContent = genderCell.textContent;
						viewLocation.textContent = locationCell.textContent;
						viewStatus.textContent = statusSpan.textContent;
						viewDob.textContent = row.dataset.dob || 'N/A';
						viewAge.textContent = row.dataset.age || 'N/A';
						viewAbout.textContent = row.dataset.about || 'N/A';

						const viewImage = document.getElementById('viewImage');
						if (viewImage) {
							viewImage.src = imgSrc || 'https://ui-avatars.com/api/?name=' +
								encodeURIComponent(nameCell.textContent) +
								'&size=80&background=ff4081&color=fff';
						}
						viewModal.style.display = 'flex';
					}

					// Edit user
					else if (target.classList.contains('edit')) {
						currentEditRow = row;

						const fullName = nameCell.textContent.trim();
						const nameParts = fullName.split(' ');
						editFName.value = nameParts[0] || '';
						editLName.value = nameParts.slice(1).join(' ') || '';
						editEmail.value = emailCell.textContent;
						editPhone.value = row.dataset.phone || '';

						const dobText = row.dataset.dob || '';
						if (dobText && dobText !== 'N/A') {
							const [day, month, year] = dobText.split('/');
							editDob.value = `${year}-${month.padStart(2,'0')}-${day.padStart(2,'0')}`;
						} else {
							editDob.value = '';
						}

						editAge.value = row.dataset.age || '';
						editGender.value = genderCell.textContent.toLowerCase() || '';
						editLocation.value = locationCell.textContent;
						editAbout.value = row.dataset.about || '';

						const profileImg = row.querySelector('.user-avatar-um');
						if (profileImg && profileImg.src) {
							editImagePreview.src = profileImg.src;
							editImagePreview.style.display = 'block';
						} else {
							editImagePreview.src = 'https://ui-avatars.com/api/?name=' +
								encodeURIComponent(nameCell.textContent) +
								'&size=100&background=ff4081&color=fff';
						}

						editModal.style.display = 'flex';
					}

					// Block/Unblock user
					else if (target.classList.contains('block') || target.classList.contains('unblock')) {
						const newStatus = target.classList.contains('block') ? 'block' : 'unblock';
						if (confirm(
								`Are you sure you want to ${newStatus === 'block' ? 'Block' : 'Unblock'} this user?`
							)) {
							fetch(routes.updateStatus.replace(':id', userId), {
									method: 'POST',
									headers: {
										'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
										'Accept': 'application/json',
										'Content-Type': 'application/json'
									},
									body: JSON.stringify({
										status: newStatus
									})
								})
								.then(res => res.json())
								.then(data => {
									if (data.success) {
										if (newStatus === 'block') {
											statusSpan.textContent = 'Blocked';
											statusSpan.style.backgroundColor = '#ff4d4f';
										} else {
											statusSpan.textContent = 'Unblocked';
											statusSpan.style.backgroundColor = '#52c41a';
										}
										statusSpan.className = 'status-um ' + newStatus;

										target.textContent = newStatus === 'block' ? 'Unblock' : 'Block';
										target.classList.toggle('block');
										target.classList.toggle('unblock');

										showToast('success', 'Status Updated',
											`User ${newStatus === 'block' ? 'blocked' : 'unblocked'} successfully!`
										);
									} else {
										showToast('error', 'Update Failed', data.message ||
											'Failed to update status.');
									}
								})
								.catch(err => {
									console.error(err);
									showToast('error', 'Error', 'Error updating status. Please try again.');
								});
						}
					}
				});

				// Edit form submit
				editForm.addEventListener('submit', function(e) {
					e.preventDefault();
					if (!currentEditRow) return;

					const formData = new FormData(editForm);
					const userId = currentEditRow.dataset.id;

					formData.append('_method', 'PUT');

					fetch(routes.updateUser.replace(':id', userId), {
							method: 'POST',
							body: formData,
							headers: {
								'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
								'Accept': 'application/json',
								'X-Requested-With': 'XMLHttpRequest'
							}
						})
						.then(response => {
							if (!response.ok) throw new Error('Network response was not ok');
							return response.json();
						})
						.then(data => {
							if (data.success) {
								currentEditRow.querySelector('.name-cell').textContent =
									`${editFName.value.trim()} ${editLName.value.trim()}`;
								currentEditRow.querySelector('.email-cell').textContent = editEmail.value
									.trim();
								currentEditRow.querySelector('.gender-cell').textContent =
									editGender.value.charAt(0).toUpperCase() + editGender.value.slice(1);
								currentEditRow.querySelector('.location-cell').textContent = editLocation.value
									.trim();

								currentEditRow.dataset.phone = editPhone.value;
								currentEditRow.dataset.dob = editDob.value ? new Date(editDob.value)
									.toLocaleDateString('en-GB') : 'N/A';
								currentEditRow.dataset.age = editAge.value || 'N/A';
								currentEditRow.dataset.about = editAbout.value || 'N/A';

								if (data.user && data.user.img) {
									const profileImg = currentEditRow.querySelector('.user-avatar-um');
									if (profileImg) {
										const imagePath = data.user.img.startsWith('uploads/') ?
											`/${data.user.img}` : `/uploads/users/${data.user.img}`;
										profileImg.src = imagePath;
									}
								}

								editModal.style.display = 'none';
								currentEditRow = null;
								showToast('success', 'User Updated', 'User updated successfully!');
							} else {
								showToast('error', 'Update Failed', data.message || 'Failed to update user.');
							}
						})
						.catch(err => {
							console.error('Error:', err);
							showToast('error', 'Error', 'Error updating user. Please try again.');
						});
				});

				// Cancel edit
				editModal.querySelector('.btn-cancel').addEventListener('click', () => {
					editModal.style.display = 'none';
					currentEditRow = null;
				});

				// Close modals when clicking outside
				window.addEventListener('click', e => {
					if (e.target === editModal) {
						editModal.style.display = 'none';
						currentEditRow = null;
					}
					if (e.target === viewModal) {
						viewModal.style.display = 'none';
					}
				});
			});
		</script>

	@endsection
