@extends('layouts.public')

@section('title', 'Events - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                    Exclusive Events
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                    Join us for premier networking events, conferences, and exclusive gatherings with GCC business leaders
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto mt-12 relative z-10">
                    <!-- Total Events -->
                    <div class="glass rounded-xl p-6 flex flex-col items-center animate-on-scroll">
                        <div class="text-4xl font-extrabold text-white mb-2">
                            <i class="fas fa-microphone-alt text-blue-400 mr-2"></i>{{ $events->total() }}
                        </div>
                        <div class="text-gray-300 text-lg font-medium">Total Events</div>
                    </div>
                    <!-- Categories -->
                    <div class="glass rounded-xl p-6 flex flex-col items-center animate-on-scroll">
                        <div class="text-4xl font-extrabold text-purple-400 mb-2">
                            <i class="fas fa-layer-group text-purple-300 mr-2"></i>{{ $categories->count() }}
                        </div>
                        <div class="text-gray-300 text-lg font-medium">Categories</div>
                    </div>
                </div>
        
        <!-- Animated background elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white opacity-5 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-white opacity-5 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 right-1/4 w-16 h-16 bg-white opacity-5 rounded-full animate-float" style="animation-delay: 2s;"></div>
    </section>

    <!-- Filters and Search -->
    <section class="py-12 bg-black/20">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('events.index') }}" class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-gray-300 font-medium mb-2">Search Interviews</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search by title, guest name, or topic..." 
                                   class="w-full px-4 py-3 pl-12 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-gray-300 font-medium mb-2">Category</label>
                        <select name="category" 
                                id="category" 
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}
                                        class="bg-gray-800 text-white">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filter Button -->
                    <div>
                        <button type="submit" 
                                class="w-full btn-gradient px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:scale-105">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </div>
                
                <!-- clear  filters -->
                <div class="mt-6 text-right">
                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('events.index') }}" 
                           class="inline-block text-sm text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fas fa-times-circle mr-1"></i>Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-16 px-12">
        <div class="container mx-auto px-4">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="gradient-card rounded-2xl overflow-hidden card-hover animate-on-scroll">
                            <!-- Event Image -->
                            <div class="relative h-48 overflow-hidden">
                                @if($event->image)
                                    <img src="{{ asset('img/' . $event->image) }}" 
                                         alt="{{ $event->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <!-- Event Type Badge -->
                                <div class="absolute top-4 left-4">
                                    @if($event->event_type === 'online')
                                        <span class="px-3 py-1 bg-blue-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-wifi mr-1"></i>Online
                                        </span>
                                    @elseif($event->event_type === 'hybrid')
                                        <span class="px-3 py-1 bg-purple-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-globe mr-1"></i>Hybrid
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-map-marker-alt mr-1"></i>In-Person
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @php
                                        $eventDateTime = $event->start_date;
                                        if ($event->start_time) {
                                            $eventDateTime = \Carbon\Carbon::parse($event->start_date->format('Y-m-d') . ' ' . $event->start_time->format('H:i:s'));
                                        }
                                        $isPast = $eventDateTime ? $eventDateTime->isPast() : false;
                                        $isToday = $eventDateTime ? $eventDateTime->isToday() : false;
                                    @endphp
                                    
                                    @if($isPast)
                                        <span class="px-3 py-1 bg-gray-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-clock mr-1"></i>Past
                                        </span>
                                    @elseif($isToday)
                                        <span class="px-3 py-1 bg-red-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-exclamation-circle mr-1"></i>Today
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-500/80 text-white text-sm rounded-full">
                                            <i class="fas fa-calendar-plus mr-1"></i>Upcoming
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Event Content -->
                            <div class="p-6">
                                <!-- Category -->
                                <div class="mb-3">
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full" 
                                          style="background-color: {{ $event->category->color ?? '#6B7280' }}20; color: {{ $event->category->color ?? '#6B7280' }};">
                                        {{ $event->category->name }}
                                    </span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 hover:text-gray-200 transition-colors duration-300">
                                    <a href="{{ route('events.show', $event) }}">{{ $event->name }}</a>
                                </h3>
                                
                                <!-- Description -->
                                <p class="text-gray-300 text-sm mb-4 line-clamp-3">{{ Str::limit($event->description, 120) }}</p>
                                
                                <!-- Event Details -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <i class="fas fa-calendar mr-2 w-4"></i>
                                        <span>{{ $event->start_date->format('M d, Y') }}</span>
                                        @if($event->start_time)
                                            <span class="ml-2">at {{ $event->start_time->format('g:i A') }}</span>
                                        @endif
                                    </div>
                                    
                                    @if($event->location)
                                        <div class="flex items-center text-gray-400 text-sm">
                                            <i class="fas fa-map-marker-alt mr-2 w-4"></i>
                                            <span>{{ Str::limit($event->location, 30) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Read More Button -->
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('events.show', $event) }}" 
                                       class="btn-gradient px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                        Read More
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                    
                                    @if($event->location_url)
                                        <a href="{{ $event->location_url }}" 
                                           target="_blank"
                                           class="text-gray-400 hover:text-white text-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($events->hasPages())
                    <div class="mt-12 flex justify-center animate-on-scroll">
                        <div class="glass rounded-2xl p-4">
                            {{ $events->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                <!-- No Events Found -->
                <div class="text-center py-20 animate-on-scroll">
                    <div class="glass rounded-2xl p-12 max-w-md mx-auto">
                        <i class="fas fa-calendar-times text-6xl text-gray-400 mb-6"></i>
                        <h3 class="text-2xl font-bold text-white mb-4">No Events Found</h3>
                        <p class="text-gray-400 mb-6">
                            @if(request()->hasAny(['search', 'category', 'status']))
                                No events match your search criteria. Try adjusting your filters.
                            @else
                                No events are currently available. Check back soon for upcoming events!
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'category', 'status']))
                            <a href="{{ route('events.index') }}" class="btn-gradient px-6 py-2 rounded-lg font-medium">
                                <i class="fas fa-refresh mr-2"></i>Show All Events
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection