
@extends('admin.layouts.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">Total Categories</div>
                            <div class="stats-number text-primary">{{ App\Models\Category::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags stats-icon text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">Total Interviews</div>
                            <div class="stats-number text-success">{{ App\Models\Interview::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microphone stats-icon text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">Total Events</div>
                            <div class="stats-number text-info">{{ App\Models\Event::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar stats-icon text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">Total Podcasts</div>
                            <div class="stats-number text-warning">{{ App\Models\Podcast::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-podcast stats-icon text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Messages Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-secondary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">Contact Messages</div>
                            <div class="stats-number text-secondary">{{ App\Models\Contact::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope stats-icon text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stats-label">New Messages (Today)</div>
                            <div class="stats-number text-info">{{ App\Models\Contact::whereDate('created_at', today())->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open stats-icon text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Recent Contact Messages</h6>
                            <p class="text-muted mb-0">Latest inquiries from visitors</p>
                        </div>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Category
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.interviews.create') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-plus me-2"></i>Add Interview
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.events.create') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-plus me-2"></i>Add Event
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.podcasts.create') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-plus me-2"></i>Add Podcast
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="row">
        <!-- Recent Interviews -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Recent Interviews</h6>
                    <a href="{{ route('admin.interviews.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @php
                        $recentInterviews = App\Models\Interview::with(['category', 'user'])->latest()->limit(5)->get();
                    @endphp
                    
                    @if($recentInterviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach($recentInterviews as $interview)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($interview->image)
                                                    <img src="{{ asset('img/' . $interview->image) }}" 
                                                         alt="{{ $interview->title }}" 
                                                         class="rounded me-3" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-microphone text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ Str::limit($interview->title, 30) }}</div>
                                                    <small class="text-muted">{{ $interview->candidate_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-{{ $interview->published_at ? 'success' : 'warning' }}">
                                                {{ $interview->published_at ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-microphone fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No interviews yet</p>
                            <a href="{{ route('admin.interviews.create') }}" class="btn btn-primary">
                                Create First Interview
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0">Upcoming Events</h6>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    @php
                        $upcomingEvents = App\Models\Event::with(['category', 'user'])
                            ->where('start_date', '>=', now())
                            ->orderBy('start_date')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @if($upcomingEvents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    @foreach($upcomingEvents as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-info rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-calendar text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ Str::limit($event->name, 30) }}</div>
                                                    <small class="text-muted">{{ $event->start_date->format('M d, Y') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <small class="text-muted">{{ $event->location }}</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No upcoming events</p>
                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                                Create First Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Content by Category Chart -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0">Content by Category</h6>
                </div>
                <div class="card-body">
                    @php
                        $categories = App\Models\Category::withCount(['interviews', 'events', 'podcasts'])->get();
                    @endphp
                    
                    @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th class="text-center">Interviews</th>
                                        <th class="text-center">Events</th>
                                        <th class="text-center">Podcasts</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <span class="badge" style="background-color: {{ $category->color }};">
                                                {{ $category->name }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $category->interviews_count }}</td>
                                        <td class="text-center">{{ $category->events_count }}</td>
                                        <td class="text-center">{{ $category->podcasts_count }}</td>
                                        <td class="text-center fw-bold">
                                            {{ $category->interviews_count + $category->events_count + $category->podcasts_count }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No categories created yet</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                Create First Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        </div>
    </div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 4px solid #007bff !important;
}
.border-left-success {
    border-left: 4px solid #28a745 !important;
}
.border-left-info {
    border-left: 4px solid #17a2b8 !important;
}
.border-left-warning {
    border-left: 4px solid #ffc107 !important;
}
.timeline {
    position: relative;
}
.timeline-item {
    display: flex;
    align-items-start;
    margin-bottom: 1rem;
}
.timeline-marker {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 1rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
}
.timeline-content {
    flex: 1;
}
</style>
@endpush