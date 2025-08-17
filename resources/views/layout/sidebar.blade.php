<!-- Admin Sidebar -->
<div class="admin-sidebar">
	<style class="sidebar-header">
		.dating-sidebar-container {
			overflow-y: auto;
			/* Functionality active */
			scrollbar-width: none;
			/* Firefox */
			-ms-overflow-style: none;
			/* IE & Edge */
		}

		.dating-sidebar-container::-webkit-scrollbar {
			display: none;
			/* Chrome, Safari, Opera */
		}
	</style>

	<div class="dating-sidebar-container">
		<div class="dating-sidebar-logo">
			<img src="{{ asset("images/shylogo1.png") }}" alt="Logo">
		</div>
		<ul class="dating-sidebar-menu">
			<li><a href="{{ route("admin.dashboard") }}" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
			<li><a href="{{ route("admin.users.index") }}"><i class="fas fa-users"></i> User Management</a></li>
			<li><a href=#><i class="fas fa-comments"></i> Chats Monitoring</a></li>
			<li><a href="{{ route("reports.index") }}"><i class="fas fa-chart-line"></i> Reports</a></li>
			<li><a href=#><i class="fas fa-credit-card"></i> Payments</a></li>
			{{-- development --}}
			<li>
				<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<i class="fas fa-sign-out-alt"></i> Logout
				</a>
				<form id="logout-form" action="{{ route("admin.logout") }}" method="POST" style="display: none;">
					@csrf
				</form>
			</li>
		</ul>
	</div>

	<script src="index.js"></script>
