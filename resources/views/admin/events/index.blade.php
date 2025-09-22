@extends('admin.layouts.layout')

@section('title', 'Events')
@section('page-title', 'Events')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Events</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Add Event
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="m-0">All Events</h6>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('admin.events.index') }}" class="d-flex flex-wrap gap-2">
                        <div class="flex-fill">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Search events..." 
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
                                <option value="">All Events</option>
                                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="past" {{ request('status') == 'past' ? 'selected' : '' }}>Past</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                        @if(request('search') || request('category') || request('status'))
                            <div>
                                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($event->image)
                                            <img src="{{ asset('img/' . $event->image) }}" 
                                                 alt="{{ $event->name }}" 
                                                 class="rounded me-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-info rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $event->name }}</div>
                                            <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $event->start_date->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $event->start_time }} - {{ $event->end_time }}</small>
                                </td>
                                <td>{{ $event->location }}</td>
                                <td>
                                    <span class="badge" style="background-color: {{ $event->category->color }}; color: white;">
                                        {{ $event->category->name }}
                                    </span>
                                </td>
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
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.events.show', $event) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.events.edit', $event) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.events.destroy', $event) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            data-confirm-delete="Are you sure you want to delete this event?">
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
                    <i class="fas fa-calendar fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No Events Found</h4>
                    <p class="text-muted mb-4">Start by creating your first event.</p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create First Event
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection