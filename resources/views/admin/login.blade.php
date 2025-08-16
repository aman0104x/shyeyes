<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Login - ShyEyes</title>
	<style>
		:root {
			--primary-pink: #ff2d75;
			--pink-light: #ff7aa8;
			--pink-dark: #d61a5e;
			--pink-gradient: linear-gradient(135deg, var(--primary-pink) 0%, var(--pink-dark) 100%);
			--text-dark: #2d3748;
			--text-light: #f8fafc;
			--bg-light: #fff5f7;
			--border-color: #fecdd3;
			--error-bg: #fee2e2;
			--error-text: #dc2626;
			--success-bg: #dcfce7;
			--success-text: #16a34a;
		}

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
			background: var(--bg-light);
			margin: 0;
			padding: 0;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			color: var(--text-dark);
		}

		.login-container {
			background: white;
			padding: 2.5rem;
			border-radius: 16px;
			box-shadow: 0 10px 25px rgba(255, 45, 117, 0.1);
			width: 100%;
			max-width: 420px;
			position: relative;
			overflow: hidden;
		}

		.login-container::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 6px;
			background: var(--pink-gradient);
		}

		.login-header {
			text-align: center;
			margin-bottom: 2rem;
		}

		.login-header h1 {
			color: var(--primary-pink);
			margin-bottom: 0.5rem;
			font-size: 1.75rem;
			font-weight: 700;
		}

		.login-header p {
			color: var(--text-dark);
			opacity: 0.8;
			font-size: 0.9rem;
		}

		.logo {
			width: 60px;
			height: 60px;
			margin: 0 auto 1rem;
			background: var(--pink-gradient);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: bold;
			font-size: 1.5rem;
		}

		.form-group {
			margin-bottom: 1.5rem;
			position: relative;
		}

		label {
			display: block;
			margin-bottom: 0.5rem;
			color: var(--text-dark);
			font-weight: 500;
			font-size: 0.9rem;
		}

		input[type="email"] {
			width: 100%;
			padding: 0.875rem 1rem;
			border: 1px solid var(--border-color);
			border-radius: 8px;
			font-size: 0.95rem;
			transition: all 0.3s ease;
			background-color: var(--bg-light);
		}

		input[type="email"]:focus {
			outline: none;
			border-color: var(--primary-pink);
			box-shadow: 0 0 0 3px rgba(255, 45, 117, 0.2);
		}

		button {
			width: 100%;
			padding: 0.875rem;
			background: var(--pink-gradient);
			color: white;
			border: none;
			border-radius: 8px;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			margin-top: 0.5rem;
		}

		button:hover {
			background: var(--primary-pink);
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(255, 45, 117, 0.3);
		}

		button:active {
			transform: translateY(0);
		}

		.error-message {
			color: var(--error-text);
			background: var(--error-bg);
			padding: 0.75rem;
			border-radius: 8px;
			margin-bottom: 1.5rem;
			font-size: 0.9rem;
			display: none;
			border-left: 4px solid var(--error-text);
		}

		.success-message {
			color: var(--success-text);
			background: var(--success-bg);
			padding: 0.75rem;
			border-radius: 8px;
			margin-bottom: 1.5rem;
			font-size: 0.9rem;
			display: none;
			border-left: 4px solid var(--success-text);
		}

		.password-toggle {
			position: absolute;
			right: 12px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: var(--primary-pink);
			font-size: 1.2rem;
			z-index: 2;
			user-select: none;
			transition: color 0.3s ease;
		}

		.password-toggle:hover {
			color: var(--pink-dark);
		}

		.form-group {
			position: relative;
			margin-bottom: 1.5rem;
		}

		/* Ensure consistent styling for both password and text inputs */
		input[type="password"],
		input[type="text"] {
			width: 100%;
			padding: 0.875rem 2.5rem 0.875rem 1rem;
			border: 1px solid var(--border-color);
			border-radius: 8px;
			font-size: 0.95rem;
			transition: all 0.3s ease;
			background-color: var(--bg-light);
			font-family: inherit;
		}

		input[type="password"]:focus,
		input[type="text"]:focus {
			outline: none;
			border-color: var(--primary-pink);
			box-shadow: 0 0 0 3px rgba(255, 45, 117, 0.2);
		}

		.forgot-link {
			display: block;
			text-align: right;
			margin-top: 0.5rem;
			color: var(--primary-pink);
			font-size: 0.85rem;
			text-decoration: none;
		}

		.forgot-link:hover {
			text-decoration: underline;
		}

		@media (max-width: 480px) {
			.login-container {
				padding: 1.5rem;
				margin: 1rem;
			}

			.login-header h1 {
				font-size: 1.5rem;
			}
		}

		/* Animation */
		@keyframes fadeIn {
			from {
				opacity: 0;
				transform: translateY(10px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.login-container {
			animation: fadeIn 0.4s ease-out;
		}
	</style>
</head>

<body>
	<div class="login-container">
		<div class="login-header">
			<div class="logo">SE</div>
			<h1>Welcome Back!</h1>
			<p>ShyEyes Admin Dashboard</p>
		</div>

		<div id="error-message" class="error-message"></div>
		<div id="success-message" class="success-message"></div>

		<form id="adminLoginForm">
			@csrf
			<div class="form-group">
				<label for="email">Email Address</label>
				<input type="email" id="email" name="email" placeholder="admin@shyeyes.com" required>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" id="password" name="password" placeholder="Enter your password" required>
				<span class="password-toggle" id="togglePassword">👁️</span>
				<a href="#" class="forgot-link">Forgot password?</a>
			</div>

			<button type="submit">Login to Dashboard</button>
		</form>
	</div>

	<script>
		// Password toggle functionality
		document.getElementById('togglePassword').addEventListener('click', function() {
			const passwordInput = document.getElementById('password');
			const isPassword = passwordInput.getAttribute('type') === 'password';

			// Toggle type
			passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

			// Toggle icon
			this.textContent = isPassword ? '👁️‍🗨️' : '👁️';

			// Maintain focus on input
			passwordInput.focus();

			// Prevent any layout shifts
			passwordInput.style.minHeight = passwordInput.offsetHeight + 'px';
		});

		// Form submission
		document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
			e.preventDefault();

			// Clear previous messages
			document.getElementById('error-message').style.display = 'none';
			document.getElementById('success-message').style.display = 'none';

			const email = document.getElementById('email').value.trim();
			const password = document.getElementById('password').value;

			try {
				const response = await fetch('/admin/login', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
					},
					body: JSON.stringify({
						email,
						password
					})
				});

				const result = await response.json();

				if (result.status) {
					const successMsg = document.getElementById('success-message');
					successMsg.style.display = 'block';
					successMsg.textContent = 'Login successful! Redirecting...';

					// Store token
					localStorage.setItem('admin_token', result.token);

					// Redirect to dashboard
					setTimeout(() => {
						window.location.href = '/admin/dashboard';
					}, 1500);
				} else {
					const errorMsg = document.getElementById('error-message');
					errorMsg.style.display = 'block';
					errorMsg.textContent = result.message || 'Login failed. Please try again.';
				}
			} catch (error) {
				const errorMsg = document.getElementById('error-message');
				errorMsg.style.display = 'block';
				errorMsg.textContent = 'Network error. Please check your connection.';
			}
		});
	</script>
</body>

</html>
