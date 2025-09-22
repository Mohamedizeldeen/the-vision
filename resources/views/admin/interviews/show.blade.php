@extends('admin.layouts.layout')

@section('title', $interview->title)
@section('page-title', $interview->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.interviews.index') }}">Interviews</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($interview->title, 30) }}</li>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.interviews.edit', $interview) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i>Actions
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.interviews.create') }}?category={{ $interview->category_id }}">
                        <i class="fas fa-copy me-2"></i>Create Similar
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('admin.interviews.destroy', $interview) }}" method="POST" style="display: inline;">
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
    </div>
@endsection

@section('content')
    <!-- Interview Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="h4 mb-2">{{ $interview->title }}</h2>
                            <div class="d-flex align-items-center gap-3 text-muted">
                                <span class="badge" style="background-color: {{ $interview->category->color }}; color: white;">
                                    {{ $interview->category->name }}
                                </span>
                                <span class="badge bg-{{ $interview->published_at ? 'success' : 'warning' }}">
                                    {{ $interview->published_at ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </div>
                        @if($interview->image)
                            <img src="{{ asset('img/' . $interview->image) }}" 
                                 alt="{{ $interview->title }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 150px; max-height: 150px; object-fit: cover;">
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Candidate:</strong> {{ $interview->candidate_name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Position:</strong> {{ $interview->position }}
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Description:</h6>
                        <div class="text-muted">{!! nl2br(e($interview->description)) !!}</div>
                    </div>
                    
                    <div class="row text-sm text-muted">
                        <div class="col-md-6">
                            <strong>Author:</strong> {{ $interview->user->name ?? 'Unknown' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Created:</strong> {{ $interview->created_at->format('M d, Y g:i A') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Updated:</strong> {{ $interview->updated_at->format('M d, Y g:i A') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Published:</strong> 
                            {{ $interview->published_at ? $interview->published_at->format('M d, Y') : 'Not published' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Quick Stats -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="m-0">Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-info mb-1">{{ $interview->category->interviews()->count() }}</h5>
                                <small class="text-muted">Category Interviews</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-1">{{ $interview->category->interviews()->whereNotNull('published_at')->count() }}</h5>
                            <small class="text-muted">Published</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.interviews.edit', $interview) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-1"></i>Edit Interview
                        </a>                    
                        
                        <a href="{{ route('admin.interviews.create') }}?category={{ $interview->category_id }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-copy me-1"></i>Create Similar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Related Interviews in {{ $interview->category->name }}</h6>
                </div>
                <div class="card-body">
                    @php
                        $relatedInterviews = $interview->category->interviews()
                            ->where('id', '!=', $interview->id)
                            ->latest()
                            ->take(6)
                            ->get();
                    @endphp
                    
                    @if($relatedInterviews->count() > 0)
                        <div class="row">
                            @foreach($relatedInterviews as $related)
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-start">
                                            @if($related->image)
                                                <img src="{{ asset('img/' . $related->image) }}" 
                                                     alt="{{ $related->title }}" 
                                                     class="rounded me-2" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-microphone text-white"></i>
                                                </div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('admin.interviews.show', $related) }}" 
                                                       class="text-decoration-none">
                                                        {{ Str::limit($related->title, 30) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">{{ $related->candidate_name }}</small>
                                                <div class="mt-1">
                                                    <span class="badge badge-sm bg-{{ $related->published_at ? 'success' : 'warning' }}">
                                                        {{ $related->published_at ? 'Published' : 'Draft' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.interviews.index') }}?category={{ $interview->category_id }}" 
                               class="btn btn-outline-primary">
                                View All {{ $interview->category->name }} Interviews
                            </a>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">No other interviews in this category.</p>
                            <a href="{{ route('admin.interviews.create') }}?category={{ $interview->category_id }}" 
                               class="btn btn-primary">
                                Create Another Interview
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection