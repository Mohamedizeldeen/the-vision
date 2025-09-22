@extends('admin.layouts.layout')

@section('title', $category->name)
@section('page-title', $category->name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-plus me-1"></i>Add Content
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ route('admin.interviews.create') }}?category={{ $category->id }}">
                        <i class="fas fa-microphone me-2"></i>New Interview
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.events.create') }}?category={{ $category->id }}">
                        <i class="fas fa-calendar me-2"></i>New Event
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.podcasts.create') }}?category={{ $category->id }}">
                        <i class="fas fa-podcast me-2"></i>New Podcast
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <!-- Category Info -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <span class="badge fs-6 px-3 py-2" style="background-color: {{ $category->color }}; color: white;">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} me-2"></i>
                                @endif
                                {{ $category->name }}
                            </span>
                        </div>
                        <div>
                            <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <p class="text-muted">{{ $category->description }}</p>
                    @endif
                    
                    <div class="row text-muted small">
                        <div class="col-md-6">
                            <strong>Slug:</strong> <code>{{ $category->slug }}</code>
                        </div>
                        <div class="col-md-6">
                            <strong>Sort Order:</strong> {{ $category->sort_order }}
                        </div>
                        <div class="col-md-6 mt-2">
                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y g:i A') }}
                        </div>
                        <div class="col-md-6 mt-2">
                            <strong>Updated:</strong> {{ $category->updated_at->format('M d, Y g:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Content Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-success mb-1">{{ $category->interviews->count() }}</h4>
                                <small class="text-muted">Interviews</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-info mb-1">{{ $category->events->count() }}</h4>
                                <small class="text-muted">Events</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning mb-1">{{ $category->podcasts->count() }}</h4>
                            <small class="text-muted">Podcasts</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Tabs -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="interviews-tab" data-bs-toggle="tab" 
                            data-bs-target="#interviews" type="button" role="tab">
                        <i class="fas fa-microphone me-1"></i>
                        Interviews ({{ $category->interviews->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="events-tab" data-bs-toggle="tab" 
                            data-bs-target="#events" type="button" role="tab">
                        <i class="fas fa-calendar me-1"></i>
                        Events ({{ $category->events->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="podcasts-tab" data-bs-toggle="tab" 
                            data-bs-target="#podcasts" type="button" role="tab">
                        <i class="fas fa-podcast me-1"></i>
                        Podcasts ({{ $category->podcasts->count() }})
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="contentTabsContent">
                <!-- Interviews Tab -->
                <div class="tab-pane fade show active" id="interviews" role="tabpanel">
                    @if($category->interviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Candidate</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->interviews as $interview)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($interview->image)
                                                    <img src="{{ asset('img/' . $interview->image) }}" 
                                                         alt="{{ $interview->title }}" 
                                                         class="rounded me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $interview->title }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $interview->candidate_name }}</td>
                                        <td>{{ $interview->position }}</td>
                                        <td>
                                            <span class="badge bg-{{ $interview->published_at ? 'success' : 'warning' }}">
                                                {{ $interview->published_at ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>{{ $interview->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.interviews.show', $interview) }}" 
                                               class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-microphone fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No interviews in this category yet.</p>
                            <a href="{{ route('admin.interviews.create') }}?category={{ $category->id }}" 
                               class="btn btn-primary">Create Interview</a>
                        </div>
                    @endif
                </div>

                <!-- Events Tab -->
                <div class="tab-pane fade" id="events" role="tabpanel">
                    @if($category->events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->start_date->format('M d, Y') }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>
                                            @if($event->start_date > now())
                                                <span class="badge bg-info">Upcoming</span>
                                            @elseif($event->end_date < now())
                                                <span class="badge bg-secondary">Past</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>{{ $event->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.events.show', $event) }}" 
                                               class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No events in this category yet.</p>
                            <a href="{{ route('admin.events.create') }}?category={{ $category->id }}" 
                               class="btn btn-primary">Create Event</a>
                        </div>
                    @endif
                </div>

                <!-- Podcasts Tab -->
                <div class="tab-pane fade" id="podcasts" role="tabpanel">
                    @if($category->podcasts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Audio</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->podcasts as $podcast)
                                    <tr>
                                        <td>{{ $podcast->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $podcast->published_at ? 'success' : 'warning' }}">
                                                {{ $podcast->published_at ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($podcast->audio_file)
                                                <i class="fas fa-file-audio text-success"></i>
                                            @else
                                                <i class="fas fa-file-audio text-muted"></i>
                                            @endif
                                        </td>
                                        <td>{{ $podcast->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.podcasts.show', $podcast) }}" 
                                               class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-podcast fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No podcasts in this category yet.</p>
                            <a href="{{ route('admin.podcasts.create') }}?category={{ $category->id }}" 
                               class="btn btn-primary">Create Podcast</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection