<!-- Dating Sidebar -->
<div class="dating-sidebar-container">
	<div class="dating-sidebar-logo">
		<img src="{{ asset("images/shylogo1.png") }}" alt="Logo">
	</div>
	<ul class="dating-sidebar-menu">
		<li><a href="{{ route("admin.dashboard") }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
		<li><a href="{{ route("admin.users.index") }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> User Management</a></li>
		<li><a href="{{ route("admin.agents.index") }}" class="{{ request()->routeIs('admin.agents.*') ? 'active' : '' }}"><i class="fas fa-user-tie"></i> Agent Managem..</a></li>
		<li><a href="#" class="{{ request()->routeIs('admin.chats.*') ? 'active' : '' }}"><i class="fas fa-comments"></i> Chats Monitoring</a></li>
		<li><a href="{{ route("reports.index") }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Reports</a></li>
		<li><a href="{{ route("admin.payment-settings.view") }}" class="{{ request()->routeIs('admin.payment-settings.*') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Account Info</a></li>
		<li><a href="{{ route("admin.transactions.index") }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> Transactions</a></li>

		<li><a href="{{ route("admin.membership-plans.index") }}" class="{{ request()->routeIs('admin.membership-plans.*') ? 'active' : '' }}"><i class="fas fa-crown"></i> Membership Pl..</a></li>
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

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const sidebar = document.querySelector('.dating-sidebar-container');
		const sidebarToggle = document.querySelector('#sidebarToggle');

		// Function to toggle sidebar
		function toggleSidebar() {
			sidebar.classList.toggle('sidebar-open');
			updateToggleButton();
		}

		// Function to handle toggle button visibility based on screen size
		function handleToggleButtonVisibility() {
			if (window.innerWidth < 992) {
				// Show toggle button on mobile
				sidebarToggle.style.display = 'flex';
				sidebarToggle.style.opacity = '1';
				sidebarToggle.style.visibility = 'visible';
			} else {
				// Hide toggle button on desktop and ensure sidebar is open
				sidebarToggle.style.display = 'none';
				sidebarToggle.style.opacity = '0';
				sidebarToggle.style.visibility = 'hidden';
				sidebar.classList.remove('sidebar-open');
			}
			updateToggleButton();
		}

		// Toggle sidebar on button click
		if (sidebarToggle) {
			sidebarToggle.addEventListener('click', function() {
				toggleSidebar();
			});
		}

		// Close sidebar when clicking on a link (for mobile)
		const sidebarLinks = document.querySelectorAll('.dating-sidebar-menu a');
		sidebarLinks.forEach(link => {
			link.addEventListener('click', function() {
				if (window.innerWidth < 992) {
					sidebar.classList.remove('sidebar-open');
					updateToggleButton();
				}
			});
		});

		// Handle window resize - update toggle button visibility and sidebar state
		window.addEventListener('resize', function() {
			handleToggleButtonVisibility();

			if (window.innerWidth >= 992) {
				sidebar.classList.remove('sidebar-open');
			}
		});

		// Update toggle button icon
		function updateToggleButton() {
			const isOpen = sidebar.classList.contains('sidebar-open');
			if (sidebarToggle) {
				sidebarToggle.innerHTML = isOpen ?
					'<i class="fas fa-times"></i>' :
					'<i class="fas fa-bars"></i>';
			}
		}

		// Initial setup - handle toggle button visibility on page load
		handleToggleButtonVisibility();
	});
</script>
