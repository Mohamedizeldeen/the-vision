@extends('admin.layouts.layout')

@section('title', $event->title)
@section('page-title', $event->title)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">{{ Str::limit($event->title, 30) }}</li>
@endsection

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        @if($event->location_url)
            <a href="{{ $event->location_url }}" target="_blank" class="btn btn-info">
                <i class="fas fa-map-marker-alt me-1"></i>View Location
            </a>
        @endif
        <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item text-danger" 
                            data-confirm-delete="Are you sure you want to delete this event?">
                        <i class="fas fa-trash me-2"></i>Delete Event
                    </button>
                </form>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if($event->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" 
                                 class="img-fluid rounded" style="width: 100%; max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt text-white fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="mb-2">{{ $event->title }}</h2>
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <span class="badge" style="background-color: {{ $event->category->color }}; color: white;">
                                    {{ $event->category->name }}
                                </span>
                                <span class="badge bg-{{ $event->published_at ? 'success' : 'warning' }}">
                                    {{ $event->published_at ? 'Published' : 'Draft' }}
                                </span>
                                @if($event->event_type)
                                    <span class="badge bg-info">
                                        @if($event->event_type === 'online')
                                            <i class="fas fa-laptop me-1"></i>Online
                                        @elseif($event->event_type === 'hybrid')
                                            <i class="fas fa-globe me-1"></i>Hybrid
                                        @else
                                            <i class="fas fa-map-marker-alt me-1"></i>In-Person
                                        @endif
                                    </span>
                                @endif
                                @php
                                    $now = now();
                                    $eventDateTime = null;
                                    if ($event->start_date) {
                                        $eventDateTime = $event->start_date;
                                        if ($event->start_time) {
                                            $eventDateTime = \Carbon\Carbon::parse($event->start_date->format('Y-m-d') . ' ' . $event->start_time->format('H:i:s'));
                                        }
                                    }
                                    $isPast = $eventDateTime ? $eventDateTime->isPast() : false;
                                    $isToday = $eventDateTime ? $eventDateTime->isToday() : false;
                                @endphp
                                @if($isPast)
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-clock me-1"></i>Past Event
                                    </span>
                                @elseif($isToday)
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-circle me-1"></i>Today
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-calendar-plus me-1"></i>Upcoming
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted mb-0">{{ $event->description }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-calendar text-primary me-2"></i>Date & Time
                                    </h6>
                                    <div class="mb-2">
                                        <strong>Start:</strong> 
                                        {{ $event->start_date->format('l, F j, Y') }}
                                        @if($event->start_time)
                                            at {{ $event->start_time->format('g:i A') }}
                                        @endif
                                    </div>
                                    @if($event->end_date)
                                        <div class="mb-2">
                                            <strong>End:</strong> 
                                            {{ $event->end_date->format('l, F j, Y') }}
                                            @if($event->end_time)
                                                at {{ $event->end_time->format('g:i A') }}
                                            @endif
                                        </div>
                                    @endif
                                    @if($event->start_date && $event->start_date->diffInDays(now()) <= 30 && !$isPast)
                                        <small class="text-info">
                                            <i class="fas fa-hourglass-half me-1"></i>
                                            {{ $eventDateTime->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light h-100">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>Location
                                    </h6>
                                    @if($event->location)
                                        <div class="mb-2">{{ $event->location }}</div>
                                        @if($event->location_url)
                                            <a href="{{ $event->location_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i>View on Map
                                            </a>
                                        @endif
                                    @else
                                        <div class="text-muted">Location TBD</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($event->content)
                        <div class="mb-4">
                            <h5>Event Details</h5>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($event->content)) !!}
                            </div>
                        </div>
                    @endif

                    @if($event->tags)
                        <div class="mb-4">
                            <h6>Tags</h6>
                            @foreach(explode(',', $event->tags) as $tag)
                                <span class="badge bg-secondary me-1"># {{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($event->meta_description)
                        <div class="mb-4">
                            <h6>Meta Description</h6>
                            <p class="text-muted">{{ $event->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Events -->
            @if($relatedEvents && $relatedEvents->count() > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="m-0">Related Events</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($relatedEvents as $related)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" 
                                                 class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-alt text-white"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('admin.events.show', $related) }}" class="text-decoration-none">
                                                    {{ Str::limit($related->title, 40) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">{{ $related->start_date->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Event Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="40%">Category:</th>
                            <td>
                                <span class="badge" style="background-color: {{ $event->category->color }}; color: white;">
                                    {{ $event->category->name }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $event->published_at ? 'success' : 'warning' }}">
                                    {{ $event->published_at ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                        </tr>
                        @if($event->published_at)
                            <tr>
                                <th>Published:</th>
                                <td>{{ $event->published_at->format('M d, Y \a\t g:i A') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Event Date:</th>
                            <td>{{ $event->start_date->format('M d, Y') }}</td>
                        </tr>
                        @if($event->start_time)
                            <tr>
                                <th>Event Time:</th>
                                <td>{{ $event->start_time->format('g:i A') }}</td>
                            </tr>
                        @endif
                        @if($event->end_date)
                            <tr>
                                <th>End Date:</th>
                                <td>{{ $event->end_date->format('M d, Y') }}</td>
                            </tr>
                        @endif
                        @if($event->end_time)
                            <tr>
                                <th>End Time:</th>
                                <td>{{ $event->end_time->format('g:i A') }}</td>
                            </tr>
                        @endif
                        @if($event->event_type)
                            <tr>
                                <th>Type:</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $event->event_type)) }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Created:</th>
                            <td>{{ $event->created_at->format('M d, Y \a\t g:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated:</th>
                            <td>{{ $event->updated_at->format('M d, Y \a\t g:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit Event
                        </a>
                        
                        @if($event->location_url)
                            <a href="{{ $event->location_url }}" target="_blank" class="btn btn-info">
                                <i class="fas fa-map-marker-alt me-1"></i>View Location
                            </a>
                        @endif

                        @if($event->published_at)
                            <form action="{{ route('admin.events.unpublish', $event) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-eye-slash me-1"></i>Unpublish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.events.publish', $event) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-globe me-1"></i>Publish Now
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Events
                        </a>
                    </div>
                </div>
            </div>

            @if($event->published_at)
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="m-0">Share Links</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Event Link:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ route('events.show', $event->id) }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        @if($event->location_url)
                            <div class="mb-2">
                                <label class="form-label small">Location Link:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" value="{{ $event->location_url }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard(this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Event Status Summary -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="m-0">Event Status</h6>
                </div>
                <div class="card-body">
                    @if($isPast)
                        <div class="alert alert-secondary mb-0">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Past Event</strong><br>
                            This event occurred {{ $eventDateTime->diffForHumans() }}.
                        </div>
                    @elseif($isToday)
                        <div class="alert alert-danger mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Event is Today!</strong><br>
                            @if($event->start_time)
                                At {{ $event->start_time->format('g:i A') }}
                            @endif
                        </div>
                    @else
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-calendar-plus me-2"></i>
                            <strong>Upcoming Event</strong><br>
                            {{ $eventDateTime->diffForHumans() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(button) {
            const input = button.parentElement.querySelector('input');
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            const icon = button.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fas fa-check text-success';
            
            setTimeout(() => {
                icon.className = originalClass;
            }, 2000);
        }
    </script>
@endsection