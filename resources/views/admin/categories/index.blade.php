@extends('admin.layouts.layout')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add Category
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">All Categories</h6>
        </div>
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Color</th>
                                <th>Content Count</th>
                                <th>Status</th>
                                <th>Sort Order</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->icon)
                                            <i class="{{ $category->icon }} me-2"></i>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $category->name }}</div>
                                            @if($category->description)
                                                <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $category->slug }}</code></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $category->color }}; color: white;">
                                        {{ $category->color }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small">
                                        <div>Interviews: {{ $category->interviews_count ?? 0 }}</div>
                                        <div>Events: {{ $category->events_count ?? 0 }}</div>
                                        <div>Podcasts: {{ $category->podcasts_count ?? 0 }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span id="status-{{ $category->id }}" 
                                          class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td>{{ $category->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.categories.show', $category) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.categories.edit', $category) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.categories.toggle', $category) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }} me-2"></i>
                                                        {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            data-confirm-delete="Are you sure you want to delete this category? This action cannot be undone.">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Categories Found</h4>
                    <p class="text-muted mb-4">Start by creating your first category to organize your content.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create First Category
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush