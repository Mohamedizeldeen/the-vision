// Admin Panel JavaScript

document.addEventListener('DOMContentLoaded', function() {
    
    // Sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
    
    // Image preview for file uploads
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewId = input.dataset.preview || input.id + '_preview';
            const preview = document.getElementById(previewId);
            
            if (file && preview) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('show');
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const message = button.dataset.confirmDelete || 'Are you sure you want to delete this item?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
    
    // Loading states for forms
    const forms = document.querySelectorAll('form[data-loading]');
    forms.forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
            }
            form.classList.add('loading');
        });
    });
    
    // Slug generation from title
    const titleInputs = document.querySelectorAll('input[data-slug-target]');
    titleInputs.forEach(function(input) {
        const targetId = input.dataset.slugTarget;
        const targetInput = document.getElementById(targetId);
        
        if (targetInput) {
            input.addEventListener('input', function() {
                const slug = generateSlug(input.value);
                targetInput.value = slug;
            });
        }
    });
    
    // Data tables initialization
    if (typeof DataTable !== 'undefined') {
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(function(table) {
            new DataTable(table, {
                responsive: true,
                pageLength: 25,
                order: [[0, 'desc']],
                language: {
                    search: 'Search:',
                    lengthMenu: 'Show _MENU_ entries',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    paginate: {
                        first: 'First',
                        last: 'Last',
                        next: 'Next',
                        previous: 'Previous'
                    }
                }
            });
        });
    }
});

// Utility Functions
function generateSlug(text) {
    return text
        .toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-')
        .trim('-');
}

function showNotification(message, type = 'success') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; max-width: 400px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto-hide after 4 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert.position-fixed');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 4000);
}

// AJAX helper for quick actions
function quickToggleStatus(url, itemId) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: itemId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Update UI element
            const statusElement = document.querySelector(`#status-${itemId}`);
            if (statusElement) {
                statusElement.classList.toggle('status-active');
                statusElement.classList.toggle('status-inactive');
                statusElement.textContent = data.status ? 'Active' : 'Inactive';
            }
        } else {
            showNotification(data.message || 'An error occurred', 'danger');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating the status', 'danger');
    });
}

// Search functionality
function initializeSearch() {
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length > 2) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            }
        });
    }
}

function performSearch(query) {
    // Implement global search functionality
    console.log('Searching for:', query);
}

// Initialize tooltips
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}