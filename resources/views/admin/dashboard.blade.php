@extends("layout.master")

@section("title", "Admin Dashboard - ShyEyes")

@section("content")
	<div class="dashboard-container">
		<!-- Header -->
		<header class="dashboard-header">
			<div class="header-content">
				<h2>Welcome, {{ Auth::guard("admin")->user()->name ?? "Admin" }}</h2>
				<p>Here’s what’s happening in your account</p>
			</div>
			{{-- <div class="header-actions">
				<div class="notification-wrapper">
					<i class="fas fa-bell" onclick="toggleNotification()"></i>
					<span class="red-dot" id="notifDot"></span>
					<div class="notification-popup" id="notifPopup">
						<ul>
							<li>You have a new message</li>
							<li>New user registered</li>
							<li>Payment received</li>
						</ul>
					</div>
				</div>
				<button class="logout-btn" onclick="logout()">Logout</button>
			</div> --}}
		</header>

		<!-- Stats -->
		<section class="stat-cards">
			<div class="stat-card pink">
				<h4>Total Users</h4>
				<p>{{ $totalUsers ?? 2000 }}</p>
			</div>
			<div class="stat-card purple">
				<h4>Active Users</h4>
				<p>{{ $activeUsers ?? 1500 }}</p>
			</div>
			<div class="stat-card orange">
				<h4>Total Payments</h4>
				<p>{{ $totalPayments ?? "23.56K" }}</p>
			</div>
			<div class="stat-card red">
				<h4>Gender Ratio</h4>
				<p>{{ $genderRatio ?? "60/40" }}</p>
			</div>
			<div class="stat-card gray">
				<h4>Today Login</h4>
				<p>{{ $todayLogin ?? 200 }}</p>
			</div>
		</section>

		<!-- Charts -->
		<section class="charts-section">
			<div class="chart-box">
				<h3>Login Activity</h3>
				<canvas id="barChart"></canvas>
			</div>
			<div class="chart-box">
				<h3>Payments Trend</h3>
				<canvas id="lineChart"></canvas>
			</div>
		</section>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		function toggleNotification() {
			const popup = document.getElementById("notifPopup");
			popup.style.display = popup.style.display === "block" ? "none" : "block";
		}

		function logout() {
			if (confirm("Do you want to log out?")) {
				window.location.href = "{{ route("admin.logout") }}";
			}
		}

		// Charts
		const barCtx = document.getElementById('barChart').getContext('2d');
		new Chart(barCtx, {
			type: 'bar',
			data: {
				labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
				datasets: [{
					label: "Logins",
					data: [120, 190, 300, 500, 200, 300, 450],
					backgroundColor: ["#ff6b6b", "#feca57", "#48dbfb", "#1dd1a1", "#5f27cd", "#ff9ff3",
						"#00d2d3"
					]
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
		});

		const lineCtx = document.getElementById('lineChart').getContext('2d');
		new Chart(lineCtx, {
			type: 'line',
			data: {
				labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
				datasets: [{
					label: "Payments",
					data: [1500, 2000, 1800, 2400],
					borderColor: "#ff6b6b",
					backgroundColor: "rgba(255,107,107,0.2)",
					fill: true,
					tension: 0.4
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false
			}
		});
	</script>

	<style>
		.dashboard-container {
			padding: 20px;
		}

		.dashboard-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 15px;
			background: white;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			margin-bottom: 30px;
		}

		.header-actions {
			display: flex;
			gap: 15px;
			align-items: center;
		}

		.logout-btn {
			padding: 8px 15px;
			border: none;
			background: #ff4d4d;
			color: white;
			border-radius: 5px;
			cursor: pointer;
		}

		.notification-wrapper {
			position: relative;
		}

		.notification-popup {
			display: none;
			position: absolute;
			top: 30px;
			right: 0;
			background: white;
			border: 1px solid #ddd;
			border-radius: 5px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			padding: 10px;
			min-width: 200px;
		}

		.red-dot {
			position: absolute;
			top: -5px;
			right: -5px;
			width: 10px;
			height: 10px;
			background: red;
			border-radius: 50%;
		}

		.stat-cards {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 20px;
			margin-bottom: 30px;
		}

		.stat-card {
			padding: 25px;
			border-radius: 10px;
			color: white;
			text-align: center;
			box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
		}

		.stat-card h4 {
			margin-bottom: 10px;
			font-size: 16px;
		}

		.stat-card p {
			font-size: 26px;
			font-weight: bold;
		}

		.pink {
			background: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);
		}

		.purple {
			background: linear-gradient(to top, #9795f0 0%, #fbc8d4 100%);
		}

		.orange {
			background: linear-gradient(to right, #f78ca0 0%, #f9748f 60%, #fe9a8b 100%);
		}

		.red {
			background: linear-gradient(to right, #ff758c 0%, #ff7eb3 100%);
		}

		.gray {
			background: linear-gradient(-20deg, #ddd6f3 0%, #faaca8 100%);
		}

		.charts-section {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
			gap: 20px;
		}

		.chart-box {
			background: white;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		}

		.chart-box h3 {
			margin-bottom: 15px;
		}
	</style>
@endsection
