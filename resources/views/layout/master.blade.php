<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield("title", "ShyEyes Admin Panel")</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset("css/style.css") }}">
	<!-- jQuery (pehle load hoga) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<!-- Toastr CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

	<!-- Toastr JS (jQuery ke baad hi load hoga) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<style>
		/* Dating Sidebar Container */
		.dating-sidebar-container {
    width: 250px;
    height: 100vh;
    background: linear-gradient(135deg, #eb6db4cf, #df3894);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 24px 20px 40px;
    position: fixed;
    left: 0;
    top: 0;
    box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
    border-radius: 0 20px 20px 0;
    z-index: 100;
    transition: transform 0.3s ease;
    overflow-y: scroll; /* Enable scroll */
    scrollbar-width: none; /* For Firefox to hide scrollbar */
}

.dating-sidebar-container::-webkit-scrollbar {
    display: none; /* Hide scrollbar for Webkit browsers (Chrome, Safari, etc.) */
}


		/* Logo */
		.dating-sidebar-logo {
			width: 100%;
			display: flex;
			justify-content: center;
			margin-bottom: 50px;
		}

		.dating-sidebar-logo img {
			width: 220px;
			height: auto;
			background: white;
			padding: 6px 12px;
			border-radius: 12px;
			box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
		}

		/* Menu */
		.dating-sidebar-menu {
			width: 100%;
			list-style: none;
			padding: 0;
			margin-bottom: auto;
		}

		.dating-sidebar-menu li {
			margin-bottom: 18px;
		}

		.dating-sidebar-menu a {
			display: flex;
			align-items: center;
			gap: 14px;
			padding: 14px 24px;
			color: #f4f4f4;
			font-size: 15px;
			font-weight: 600;
			text-decoration: none;
			border-radius: 16px;
			background: rgba(255 255 255 / 0.08);
			box-shadow: inset 0 0 8px rgba(255 255 255 / 0.1);
			transition: all 0.3s ease;
		}

		/* Icon colors by menu item */
		.dating-sidebar-menu li:nth-child(1) a i {
			color: #f9d342;
		}

		/* Home - yellow */
		.dating-sidebar-menu li:nth-child(2) a i {
			color: #64d8e8;
		}

		/* User Management - teal */
		.dating-sidebar-menu li:nth-child(3) a i {
			color: #c56ce5;
		}

		/* Agent Management - purple */
		.dating-sidebar-menu li:nth-child(4) a i {
			color: #7fdb8f;
		}

		/* Chats Monitoring - green */
		.dating-sidebar-menu li:nth-child(5) a i {
			color: #ff9264;
		}

		/* Reports - orange */
		.dating-sidebar-menu li:nth-child(6) a i {
			color: #4e73df;
		}

		/* Payments - blue */
		.dating-sidebar-menu li:nth-child(7) a i {
			color: #f6c23e;
		}

		/* Membership Plans - yellow */
		/* Hover and active */
		.dating-sidebar-menu a:hover,
		.dating-sidebar-menu a.active {
			background: rgba(255 255 255 / 0.3);
			color: white;
			box-shadow: 0 4px 12px rgba(255 255 255 / 0.6);
		}

		.dating-sidebar-menu a:hover i,
		.dating-sidebar-menu a.active i {
			color: white;
		}

		/* Sidebar Toggle Button - Hidden by default on larger screens */
		.sidebar-toggle-btn {
			position: fixed;
			top: 20px;
			left: 260px;
			/* Position next to sidebar */
			z-index: 101;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background: #df3894;
			color: white;
			border: none;
			display: none; /* Hidden by default */
			align-items: center;
			justify-content: center;
			font-size: 18px;
			cursor: pointer;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
			transition: all 0.3s ease;
			opacity: 0;
			visibility: hidden;
		}

		.sidebar-toggle-btn:hover {
			background: #eb6db4;
			transform: scale(1.1);
		}

		/* Main content area */
		.main-content {
			flex: 1;
			margin-left: 250px;
			padding: 30px;
			padding-top: 30px;
			transition: margin-left 0.3s ease;
		}

		/* Responsive styles */
		@media (max-width: 992px) {
			.dating-sidebar-container {
				transform: translateX(-100%);
				width: 240px;
				overflow-y: auto; /* Enable vertical scrolling */
				-webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
			}

			.dating-sidebar-container.sidebar-open {
				transform: translateX(0);
			}

			.sidebar-toggle-btn {
				left: 20px;
				top: 20px;
				display: flex; /* Show toggle button on mobile */
				opacity: 1;
				visibility: visible;
			}

			.main-content {
				margin-left: 0;
				padding-top: 30px;
			}
		}

		@media (max-width: 576px) {
			.main-content {
				padding: 20px;
				padding-top: 20px;
			}

			.dating-sidebar-logo img {
				width: 180px;
			}

			.dating-sidebar-menu a {
				padding: 12px 20px;
				font-size: 14px;
			}

			.sidebar-toggle-btn {
				left: 15px;
				top: 15px;
				width: 35px;
				height: 35px;
				font-size: 16px;
			}
		}
	</style>

	@stack("styles")
</head>

<body>
	<div class="admin-wrapper">
		<!-- Sidebar Toggle Button -->
		<button class="sidebar-toggle-btn" id="sidebarToggle">
			<i class="fas fa-bars"></i>
		</button>

		<!-- Sidebar -->
		@include("layout.sidebar")

		<!-- Main Content -->
		<div class="main-content">
			<!-- Top Navigation -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
				<div class="container-fluid">
					{{-- <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.settings') }}">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
				</div>
			</nav>

			<!-- Page Content -->
			<main class="container-fluid py-4">
				@yield("content")
			</main>
		</div>
	</div>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	@stack("scripts")
</body>

</html>
