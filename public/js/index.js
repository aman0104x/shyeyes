// Transaction table filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const transactionTable = document.getElementById('transactionTable');
    const tableBody = transactionTable.querySelector('tbody');
    const rows = tableBody.querySelectorAll('tr');

    // Function to filter transactions
    function filterTransactions() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        rows.forEach(row => {
            if (row.cells.length < 8) return; // Skip empty rows

            const userName = row.getAttribute('data-user') || '';
            const planName = row.getAttribute('data-plan') || '';
            const amount = row.getAttribute('data-amount') || '';
            const paymentMethod = row.getAttribute('data-method') || '';
            const status = row.getAttribute('data-status') || '';
            const date = row.getAttribute('data-date') || '';

            // Check if row matches search term
            const matchesSearch = searchTerm === '' || 
                userName.toLowerCase().includes(searchTerm) ||
                planName.toLowerCase().includes(searchTerm) ||
                amount.includes(searchTerm) ||
                paymentMethod.toLowerCase().includes(searchTerm) ||
                date.toLowerCase().includes(searchTerm);

            // Check if row matches status filter
            const matchesStatus = statusValue === 'all' || status === statusValue;

            // Show/hide row based on filters
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Add event listeners for filtering
    if (searchInput) {
        searchInput.addEventListener('input', filterTransactions);
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterTransactions);
    }

    // Initial filter to handle any pre-filled values
    filterTransactions();

    // Add debounce function for search input to improve performance
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Apply debounce to search input (300ms delay)
    if (searchInput) {
        const debouncedFilter = debounce(filterTransactions, 300);
        searchInput.addEventListener('input', debouncedFilter);
    }
});

// Toast notification functionality
function showToast(type, title, message, duration = 3000) {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-header">
            <span class="toast-title">${type === 'success' ? '✅' : '❌'} ${title}</span>
            <button class="toast-close" onclick="this.closest('.toast').remove()">&times;</button>
        </div>
        <div class="toast-body">${message}</div>
    `;

    toastContainer.appendChild(toast);
    
    // Show toast with animation
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Remove toast after duration
    setTimeout(() => {
        toast.remove();
    }, duration);
}
