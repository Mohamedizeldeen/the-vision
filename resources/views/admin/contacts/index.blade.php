@extends('admin.layouts.layout')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Contacts</li>
@endsection

@section('page-actions')
    <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary" onclick="refreshPage()">
            <i class="fas fa-sync-alt me-1"></i>Refresh
        </button>
        <button type="button" class="btn btn-outline-danger" id="bulkDeleteBtn" style="display: none;" onclick="bulkDelete()">
            <i class="fas fa-trash me-1"></i>Delete Selected
        </button>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0">All Contact Messages</h6>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#filterCollapse" aria-expanded="false">
                        <i class="fas fa-filter me-1"></i>Filters
                    </button>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="collapse mt-3" id="filterCollapse">
                <form method="GET" action="{{ route('admin.contacts.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Name, email, or company...">
                    </div>
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card-body">
            @if($contacts->count() > 0)
                <form id="bulkForm" method="POST" action="{{ route('admin.contacts.bulk-delete') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Contact Info</th>
                                    <th>Company</th>
                                    <th>Message Preview</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" 
                                               class="form-check-input contact-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px;">
                                                <span class="text-white fw-bold">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $contact->name }}</div>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($contact->company)
                                            <span class="badge bg-info">{{ $contact->company }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ Str::limit($contact->tell_us_your_story, 100) }}</p>
                                    </td>
                                    <td>
                                        <div>{{ $contact->created_at->format('M d, Y') }}</div>
                                        <small class="text-muted">{{ $contact->created_at->format('g:i A') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.contacts.show', $contact) }}">
                                                        <i class="fas fa-eye me-2"></i>View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="mailto:{{ $contact->email }}">
                                                        <i class="fas fa-reply me-2"></i>Reply via Email
                                                    </a>
                                                </li>
                                                
                                              
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $contacts->firstItem() }} to {{ $contacts->lastItem() }} of {{ $contacts->total() }} results
                    </div>
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-envelope-open fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Contact Messages</h4>
                    <p class="text-muted mb-0">No contact messages have been received yet.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const contactCheckboxes = document.querySelectorAll('.contact-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                contactCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkDeleteBtn();
            });

            // Individual checkbox change
            contactCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
                    selectAllCheckbox.checked = checkedBoxes.length === contactCheckboxes.length;
                    toggleBulkDeleteBtn();
                });
            });

            function toggleBulkDeleteBtn() {
                const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
                if (checkedBoxes.length > 0) {
                    bulkDeleteBtn.style.display = 'inline-block';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }
        });

        function refreshPage() {
            window.location.reload();
        }

        function bulkDelete() {
            const checkedBoxes = document.querySelectorAll('.contact-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select contacts to delete.');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${checkedBoxes.length} contact message(s)?`)) {
                document.getElementById('bulkForm').submit();
            }
        }

        // Auto-submit form when date inputs change
        document.getElementById('date_from').addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });

        document.getElementById('date_to').addEventListener('change', function() {
            if (this.value) {
                this.form.submit();
            }
        });
    </script>
@endsection