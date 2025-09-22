@extends('admin.layouts.layout')

@section('title', 'Podcasts')
@section('page-title', 'Podcasts')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Podcasts</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.podcasts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add Podcast
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">All Podcasts</h6>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('admin.podcasts.index') }}" class="d-flex flex-wrap gap-2">
                        <div class="flex-fill">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search podcasts..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div>
                            <select name="category" class="form-select" style="min-width: 150px;">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select name="status" class="form-select" style="min-width: 120px;">
                                <option value="">All Podcasts</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        @if(request('search') || request('category') || request('status'))
                            <div>
                                <a href="{{ route('admin.podcasts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            @if($podcasts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Audio</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($podcasts as $podcast)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded me-3 d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-podcast text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ Str::limit($podcast->title, 40) }}</div>
                                            <small class="text-muted">{{ Str::limit($podcast->description, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: {{ $podcast->category->color }}; color: white;">
                                        {{ $podcast->category->name }}
                                    </span>
                                </td>
                                <td>
                                    @if($podcast->audio_file)
                                        <span class="badge bg-success">
                                            <i class="fas fa-file-audio me-1"></i>Available
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-file-audio me-1"></i>No Audio
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $podcast->published_at ? 'success' : 'warning' }}">
                                        {{ $podcast->published_at ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $podcast->published_at ? $podcast->published_at->format('M d, Y') : 'Not published' }}
                                </td>
                                <td>{{ $podcast->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.podcasts.show', $podcast) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.podcasts.edit', $podcast) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            @if($podcast->audio_file)
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.podcasts.stream', $podcast) }}" target="_blank">
                                                        <i class="fas fa-play me-2"></i>Listen
                                                    </a>
                                                </li>
                                            @endif
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.podcasts.destroy', $podcast) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            data-confirm-delete="Are you sure you want to delete this podcast?">
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
                    <i class="fas fa-podcast fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Podcasts Found</h4>
                    <p class="text-muted mb-4">Start by creating your first podcast.</p>
                    <a href="{{ route('admin.podcasts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create First Podcast
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection