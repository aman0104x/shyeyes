@extends("layout.master")

@section("title", "User Reports - ShyEyes Admin")

@section("content")
	<style>
		.reports-wrapper {
			background: #f8fafc;
			padding: 2rem;
			font-family: 'Inter', sans-serif;
			min-height: calc(100vh - 80px);
		}

		.reports-title {
			color: #ef4444;
			font-size: 1.75rem;
			margin-bottom: 1.5rem;
			font-weight: 700;
			display: flex;
			align-items: center;
			gap: 0.75rem;
		}

		.filters-ur {
			display: flex;
			justify-content: space-between;
			margin-bottom: 1.5rem;
			flex-wrap: wrap;
			gap: 1rem;
			background: white;
			padding: 1rem;
			border-radius: 0.75rem;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
		}

		.search-box-ur {
			padding: 0.625rem 1rem;
			border: 1px solid #e2e8f0;
			border-radius: 0.5rem;
			width: 100%;
			max-width: 300px;
			font-size: 0.875rem;
			transition: all 0.2s;
		}

		.search-box-ur:focus {
			border-color: #93c5fd;
			outline: none;
			box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
		}

		.date-filter-ur {
			padding: 0.625rem 1rem;
			border: 1px solid #e2e8f0;
			border-radius: 0.5rem;
			width: 100%;
			max-width: 200px;
			font-size: 0.875rem;
			background-color: white;
			cursor: pointer;
		}

		.report-container-ur {
			background: white;
			border-radius: 0.75rem;
			padding: 1.5rem;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
			width: 100%;
		}

		.report-ur {
			display: flex;
			align-items: center;
			justify-content: space-between;
			border-bottom: 1px solid #f1f5f9;
			padding: 1.25rem 0;
			flex-wrap: wrap;
			transition: background 0.2s;
		}

		.report-ur:hover {
			background: #f8fafc;
		}

		.report-ur:last-child {
			border-bottom: none;
		}

		.report-info-ur {
			display: flex;
			align-items: center;
			gap: 1rem;
			flex: 1;
			min-width: 300px;
		}

		.user-photo-ur {
			width: 3.5rem;
			height: 3.5rem;
			border-radius: 50%;
			object-fit: cover;
			border: 2px solid #e2e8f0;
			flex-shrink: 0;
		}

		.details-ur {
			line-height: 1.5;
			flex: 1;
		}

		.details-ur .reported-ur {
			font-weight: 600;
			font-size: 1rem;
			color: #1e293b;
			margin-bottom: 0.25rem;
		}

		.details-ur .reporter-ur {
			font-size: 0.875rem;
			color: #64748b;
			margin-bottom: 0.25rem;
		}

		.details-ur .reason-ur {
			font-size: 0.875rem;
			color: #475569;
			background: #f1f5f9;
			padding: 0.25rem 0.5rem;
			border-radius: 0.25rem;
			display: inline-block;
			margin-top: 0.25rem;
		}

		.timestamp-ur {
			font-size: 0.75rem;
			color: #94a3b8;
			margin-top: 0.5rem;
		}

		.status-badge-ur {
			padding: 0.375rem 0.75rem;
			font-size: 0.75rem;
			border-radius: 1rem;
			text-align: center;
			min-width: 80px;
			font-weight: 600;
			margin-right: 1rem;
		}

		.status-badge-pending-ur {
			background: #ffedd5;
			color: #9a3412;
		}

		.status-badge-resolved-ur {
			background: #dcfce7;
			color: #166534;
		}

		.actions-ur {
			display: flex;
			gap: 0.75rem;
			flex-shrink: 0;
			margin-left: auto;
		}

		.actions-ur button {
			padding: 0.5rem 0.875rem;
			border: none;
			border-radius: 0.5rem;
			color: white;
			cursor: pointer;
			font-size: 0.8125rem;
			font-weight: 500;
			transition: all 0.2s;
			display: flex;
			align-items: center;
			gap: 0.375rem;
		}

		.actions-ur button:hover {
			transform: translateY(-1px);
		}

		.actions-ur button:active {
			transform: translateY(0);
		}

		.view-ur {
			background: #3b82f6;
		}

		.view-ur:hover {
			background: #2563eb;
		}

		.block-ur {
			background: #f59e0b;
		}

		.block-ur:hover {
			background: #d97706;
		}

		.delete-ur {
			background: #ef4444;
		}

		.delete-ur:hover {
			background: #dc2626;
		}

		.no-reports {
			text-align: center;
			padding: 3rem;
			color: #64748b;
		}

		.no-reports i {
			font-size: 3rem;
			color: #cbd5e1;
			margin-bottom: 1rem;
		}

		.no-reports h3 {
			font-size: 1.25rem;
			font-weight: 600;
			margin-bottom: 0.5rem;
			color: #1e293b;
		}

		.no-reports p {
			font-size: 0.875rem;
		}

		.pagination {
			display: flex;
			justify-content: center;
			margin-top: 2rem;
			margin-bottom: 2rem;
		}

		.pagination .page-item.active .page-link {
			background-color: #ef4444;
			border-color: #ef4444;
		}

		.pagination .page-link {
			color: #ef4444;
		}

		@media (max-width: 768px) {
			.reports-wrapper {
				padding: 1rem;
			}

			.report-ur {
				flex-direction: column;
				align-items: flex-start;
				gap: 1rem;
				padding: 1.5rem 0;
			}

			.report-info-ur {
				width: 100%;
			}

			.actions-ur {
				width: 100%;
				justify-content: flex-end;
			}

			.status-badge-ur {
				margin-left: auto;
				margin-right: 0;
			}
		}

		.report-details-content {
			padding: 1rem;
		}

		.report-details-content .user-section {
			display: flex;
			align-items: center;
			gap: 1rem;
			margin-bottom: 1.5rem;
			padding: 1rem;
			background: #f8f9fa;
			border-radius: 0.5rem;
		}

		.report-details-content .user-avatar {
			width: 60px;
			height: 60px;
			border-radius: 50%;
			object-fit: cover;
		}

		.report-details-content .user-info h6 {
			margin: 0;
			font-weight: 600;
			color: #1e293b;
		}

		.report-details-content .user-info small {
			color: #64748b;
		}

		.report-details-content .report-info {
			background: #f8f9fa;
			padding: 1.5rem;
			border-radius: 0.5rem;
			margin-bottom: 1rem;
		}

		.report-details-content .report-info p {
			margin-bottom: 0.75rem;
		}

		.report-details-content .badge {
			font-size: 0.875rem;
			padding: 0.5rem 0.75rem;
		}

		.modal {
			z-index: 1055 !important;
			/* Bootstrap default 1055 hota hai */
		}

		.modal-backdrop {
			z-index: 1050 !important;
		}

		.modal-content {
			width: 650px !important;
			margin-left: 100px !important;
		}
	</style>

	<div class="reports-wrapper">
		<h1 class="reports-title">
			🚨 User Reports
		</h1>

		<div class="filters-ur">
			<input type="text" id="searchReports" placeholder="Search reports..." class="search-box-ur" />
			<select id="dateFilter" class="date-filter-ur">
				<option value="">All Time</option>
				<option value="today">Today</option>
				<option value="this-week">This Week</option>
				<option value="this-month">This Month</option>
			</select>
		</div>

		<div class="report-container-ur">
			@forelse($reports as $report)
				<div class="report-ur" data-report-id="{{ $report->id }}">
					<div class="report-info-ur">
						@php
							$reported = $report->reported;
							$reportedImg = $reported->img ?? "";
							$fullName = trim(($reported->f_name ?? "") . " " . ($reported->l_name ?? ""));
							$imagePath = Str::startsWith($reportedImg, "uploads/")
							    ? asset($reportedImg)
							    : (!empty($reportedImg)
							        ? asset("uploads/users/" . $reportedImg)
							        : null);
						@endphp

						<img
							src="{{ !empty($reportedImg) ? $imagePath : "https://ui-avatars.com/api/?name=" . urlencode($fullName) . "&size=60&background=ff4081&color=fff" }}"
							class="user-photo-ur" alt="{{ $fullName }}">

						<div class="details-ur">
							<div class="reported-ur">Reported: {{ $report->reported->full_name }} by {{ $report->reporter->full_name }}</div>
							{{-- <div class="reporter-ur">Reported by: {{ $report->reporter->full_name }}</div> --}}
							<div class="reason-ur">{{ $report->reason }}</div>
							<div class="timestamp-ur">{{ $report->created_at->format('M d, Y \a\t h:i A') }}</div>
						</div>
					</div>

					<div class="actions-ur">
						<button class="view-ur" data-bs-toggle="modal" data-bs-target="#reportModal"
							onclick="viewReport({{ $report->id }})">
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor"
								stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
								<circle cx="12" cy="12" r="3"></circle>
							</svg>
							View
						</button>

						<button class="block-ur" onclick="blockUser({{ $report->reported_id }})">
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
								stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="10"></circle>
								<line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
							</svg>
							Block
						</button>
						<button class="delete-ur" onclick="deleteReport({{ $report->id }})">
							<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
								stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<polyline points="3 6 5 6 21 6"></polyline>
								<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
								<line x1="10" y1="11" x2="10" y2="17"></line>
								<line x1="14" y1="11" x2="14" y2="17"></line>
							</svg>
							Delete
						</button>
					</div>
				</div>
			@empty
				<div class="no-reports">
					<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<line x1="12" y1="8" x2="12" y2="12"></line>
						<line x1="12" y1="16" x2="12.01" y2="16"></line>
					</svg>
					<h3>No Reports Found</h3>
					<p>There are currently no user reports to display.</p>
				</div>
			@endforelse
		</div>

		@if ($reports->count())
			<div class="pagination mt-6">
				{{ $reports->links() }}
			</div>
		@endif
	</div>

	<!-- Report Details Modal -->
	<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-light">
					<h5 class="modal-title">
						<i class="fas fa-exclamation-triangle text-danger me-2"></i>
						Report Details
					</h5>
					<!-- Top right close button -->
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
				</div>
				<div class="modal-body" id="reportDetails">
					<div class="py-5 text-center">
						<div class="spinner-border text-danger" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<p class="text-muted mt-3">Loading report details...</p>
					</div>
				</div>
				<!-- Footer removed -->
			</div>
		</div>
	</div>

	@push("scripts")
		<script>
			$(document).ready(function() {
				// Search functionality
				$('#searchReports').on('keyup', function() {
					let value = $(this).val().toLowerCase();
					$('.report-ur').filter(function() {
						$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				});

				// Date filter functionality
				$('#dateFilter').on('change', function() {
					let filter = $(this).val();
					filterReportsByDate(filter);
				});
			});

			function viewReport(reportId) {
				// Show loading state
				$('#reportDetails').html(`
					<div class="text-center py-5">
						<div class="spinner-border text-danger" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<p class="mt-3 text-muted">Loading report details...</p>
					</div>
				`);

				// Fetch report details via AJAX
				$.ajax({
					url: `/admin/reports/${reportId}/details`,
					type: 'GET',
					success: function(response) {
						if (response.success) {
							const data = response.data;
							const modalContent = `
								<div class="report-details-content">
									<div class="row">
										<div class="col-md-6">
											<div class="user-section">
												<img src="${data.reported.image}" class="user-avatar" alt="${data.reported.name}">
												<div class="user-info">
													<h6>${data.reported.name}</h6>
													<small class="text-muted">${data.reported.email}</small>
													<br>
													<small class="text-danger">Reported User</small>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="user-section">
												<img src="${data.reporter.image}" class="user-avatar" alt="${data.reporter.name}">
												<div class="user-info">
													<h6>${data.reporter.name}</h6>
													<small class="text-muted">${data.reporter.email}</small>
													<br>
													<small class="text-primary">Reporter</small>
												</div>
											</div>
										</div>
									</div>

									<div class="report-info">
										<h6 class="mb-3">
											<i class="fas fa-info-circle text-info me-2"></i>
											Report Information
										</h6>
										<div class="row">
											<div class="col-md-6">
												<p><strong>Report ID:</strong> <span class="badge bg-secondary">#${data.id}</span></p>
												<p><strong>Reason:</strong> <span class="badge bg-danger">${data.reason || 'Not specified'}</span></p>
											</div>
											<div class="col-md-6">
												<p><strong>Reported on:</strong> <span class="text-muted">${data.created_at_full}</span></p>
											</div>
										</div>
										${data.details ? `
																									<div class="mt-3">
																										<strong>Additional Details:</strong>
																										<div class="bg-light p-3 rounded mt-2">
																											${data.details}
																										</div>
																									</div>
																								` : ''}
									</div>

									<div class="d-flex justify-content-between mt-4 g-5">
	<!-- Left side -->
	<button type="button" class="btn btn-warning btn-sm" onclick="blockUser(${data.reported.id})">
		<i class="fas fa-ban me-1"></i>Block User
	</button>

	<!-- Right side -->
	<button type="button" class="btn btn-danger btn-sm" onclick="deleteReport(${data.id})">
		<i class="fas fa-trash me-1"></i>Delete Report
	</button>
</div>

								</div>
							`;

							$('#reportDetails').html(modalContent);
						}
					},
					error: function() {
						$('#reportDetails').html(`
							<div class="text-center py-5">
								<i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
								<h5 class="mt-3 text-danger">Error Loading Report</h5>
								<p class="text-muted">Failed to load report details. Please try again.</p>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							</div>
						`);
					}
				});
			}

			function blockUser(userId) {
				if (confirm('Are you sure you want to block this user? This action cannot be undone.')) {
					$.post(`/admin/users/${userId}/status`, {
						_token: '{{ csrf_token() }}',
						status: 'block'
					}, function(response) {
						if (response.success) {
							toastr.success('User blocked successfully');
							location.reload();
						} else {
							toastr.error(response.message || 'Failed to block user');
						}
					}).fail(function() {
						toastr.error('Error blocking user');
					});
				}
			}

			function deleteReport(reportId) {
				if (confirm('Are you sure you want to delete this report? This action cannot be undone.')) {
					$.ajax({
						url: `/admin/reports/${reportId}`,
						type: 'DELETE',
						data: {
							_token: '{{ csrf_token() }}'
						},
						success: function(response) {
							toastr.success('Report deleted successfully');
							location.reload();
						},
						error: function() {
							toastr.error('Error deleting report');
						}
					});
				}
			}

			function filterReportsByDate(filter) {
				const reports = $('.report-ur');
				const today = new Date();
				today.setHours(0, 0, 0, 0);

				reports.each(function() {
					const timestampText = $(this).find('.timestamp-ur').text();
					const reportDate = new Date(timestampText.replace(' at ', ' '));
					let show = true;

					switch (filter) {
						case 'today':
							show = reportDate >= today;
							break;
						case 'this-week':
							const weekStart = new Date(today);
							weekStart.setDate(today.getDate() - today.getDay());
							show = reportDate >= weekStart;
							break;
						case 'this-month':
							const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
							show = reportDate >= monthStart;
							break;
						default:
							show = true;
					}

					$(this).toggle(show);
				});
			}
		</script>
	@endpush
@endsection
