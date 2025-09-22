@extends('admin.layouts.layout')

@section('title', 'Interviews')
@section('page-title', 'Interviews')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Interviews</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.interviews.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add Interview
    </a>
@endsection

@section('content')
    <!-- Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.interviews.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search interviews..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h6 class="m-0">All Interviews ({{ $interviews->total() }})</h6>
        </div>
        <div class="card-body">
            @if($interviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Interview</th>
                                <th>Candidate</th>
                                <th>Position</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($interviews as $interview)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($interview->image)
                                            <img src="{{ asset('img/' . $interview->image) }}" 
                                                 alt="{{ $interview->title }}" 
                                                 class="rounded me-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-microphone text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ Str::limit($interview->title, 40) }}</div>
                                            <small class="text-muted">{{ Str::limit($interview->description, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $interview->candidate_name }}</td>
                                <td>{{ $interview->position }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $interview->category->color }}; color: white;">
                                        {{ $interview->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $interview->published_at ? 'success' : 'warning' }}">
                                        {{ $interview->published_at ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $interview->published_at ? $interview->published_at->format('M d, Y') : 'Not published' }}
                                </td>
                                <td>{{ $interview->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.interviews.show', $interview) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.interviews.edit', $interview) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.interviews.destroy', $interview) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            data-confirm-delete="Are you sure you want to delete this interview?">
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $interviews->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-microphone fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Interviews Found</h4>
                    <p class="text-muted mb-4">Start by creating your first interview.</p>
                    <a href="{{ route('admin.interviews.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create First Interview
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection