@extends('layouts.public')

@section('title', $event->name . ' - Events - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Event Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <!-- Background Image -->
        @if($event->image)
            <div class="absolute inset-0">
                <img src="{{ asset('img/' . $event->image) }}" 
                     alt="{{ $event->name }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/70"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black"></div>
        @endif
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8 animate-slide-in-left">
                    <ol class="flex space-x-2 text-sm">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors duration-300">Home</a></li>
                        <li><span class="text-gray-500">/</span></li>
                        <li><a href="{{ route('events.index') }}" class="text-gray-300 hover:text-white transition-colors duration-300">Events</a></li>
                        <li><span class="text-gray-500">/</span></li>
                        <li class="text-white">{{ Str::limit($event->name, 30) }}</li>
                    </ol>
                </nav>
                
                <!-- Event Info -->
                <div class="animate-fade-in-up">
                    <!-- Category -->
                    <div class="mb-4">
                        <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full" 
                              style="background-color: {{ $event->category->color ?? '#6B7280' }}; color: white;">
                            {{ $event->category->name }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        {{ $event->name }}
                    </h1>
                    
                    <!-- Event Meta -->
                    <div class="flex flex-wrap gap-6 text-gray-300 mb-8">
                        <!-- Date & Time -->
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-3 text-xl"></i>
                            <div>
                                <div class="font-medium">{{ $event->start_date->format('l, F j, Y') }}</div>
                                @if($event->start_time)
                                    <div class="text-sm text-gray-400">{{ $event->start_time->format('g:i A') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Location -->
                        @if($event->location)
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-xl"></i>
                                <div>
                                    <div class="font-medium">{{ $event->location }}</div>
                                    @if($event->location_url)
                                        <a href="{{ $event->location_url }}" target="_blank" 
                                           class="text-sm text-blue-400 hover:text-blue-300 transition-colors duration-300">
                                            View on Map <i class="fas fa-external-link-alt ml-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <!-- Event Type -->
                        <div class="flex items-center">
                            @if($event->event_type === 'online')
                                <i class="fas fa-wifi mr-3 text-xl text-blue-400"></i>
                                <span class="font-medium">Online Event</span>
                            @elseif($event->event_type === 'hybrid')
                                <i class="fas fa-globe mr-3 text-xl text-purple-400"></i>
                                <span class="font-medium">Hybrid Event</span>
                            @else
                                <i class="fas fa-users mr-3 text-xl text-green-400"></i>
                                <span class="font-medium">In-Person Event</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    @php
                        $eventDateTime = $event->start_date;
                        if ($event->start_time) {
                            $eventDateTime = \Carbon\Carbon::parse($event->start_date->format('Y-m-d') . ' ' . $event->start_time->format('H:i:s'));
                        }
                        $isPast = $eventDateTime ? $eventDateTime->isPast() : false;
                        $isToday = $eventDateTime ? $eventDateTime->isToday() : false;
                    @endphp
                    
                    <div class="inline-block mb-8">
                        @if($isPast)
                            <span class="px-6 py-3 bg-gray-500/80 text-white rounded-full font-medium">
                                <i class="fas fa-clock mr-2"></i>Past Event
                            </span>
                        @elseif($isToday)
                            <span class="px-6 py-3 bg-red-500/80 text-white rounded-full font-medium animate-pulse">
                                <i class="fas fa-exclamation-circle mr-2"></i>Happening Today
                            </span>
                        @else
                            <span class="px-6 py-3 bg-green-500/80 text-white rounded-full font-medium">
                                <i class="fas fa-calendar-plus mr-2"></i>Upcoming Event
                            </span>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4">
                        @if(!$isPast && $event->location_url)
                            <a href="{{ $event->location_url }}" 
                               target="_blank"
                               class="btn-gradient px-8 py-4 rounded-lg font-medium text-lg inline-flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Get Directions
                            </a>
                        @endif
                        
                        <button onclick="shareEvent()" 
                                class="px-8 py-4 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-share mr-2"></i>
                            Share Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Event Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="glass rounded-2xl p-8 animate-on-scroll">
                        <h2 class="text-3xl font-bold text-white mb-6">About This Event</h2>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-gray-300 text-lg leading-relaxed mb-6">{{ $event->description }}</p>
                            
                            @if($event->content)
                                <div class="text-gray-300 leading-relaxed">
                                    {!! nl2br(e($event->content)) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Event Details Card -->
                    <div class="glass rounded-2xl p-6 mb-8 animate-on-scroll">
                        <h3 class="text-xl font-bold text-white mb-6">Event Details</h3>
                        
                        <div class="space-y-4">
                            <!-- Date -->
                            <div class="flex items-start">
                                <i class="fas fa-calendar text-blue-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <div class="text-white font-medium">{{ $event->start_date->format('F j, Y') }}</div>
                                    @if($event->end_date && !$event->end_date->isSameDay($event->start_date))
                                        <div class="text-gray-400 text-sm">to {{ $event->end_date->format('F j, Y') }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Time -->
                            @if($event->start_time)
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-green-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">{{ $event->start_time->format('g:i A') }}</div>
                                        @if($event->end_time)
                                            <div class="text-gray-400 text-sm">to {{ $event->end_time->format('g:i A') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Location -->
                            @if($event->location)
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-red-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">{{ $event->location }}</div>
                                        @if($event->location_url)
                                            <a href="{{ $event->location_url }}" target="_blank" 
                                               class="text-blue-400 hover:text-blue-300 text-sm transition-colors duration-300">
                                                View Location <i class="fas fa-external-link-alt ml-1"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Event Type -->
                            <div class="flex items-start">
                                @if($event->event_type === 'online')
                                    <i class="fas fa-wifi text-blue-400 mt-1 mr-3 w-5"></i>
                                    <div class="text-white font-medium">Online Event</div>
                                @elseif($event->event_type === 'hybrid')
                                    <i class="fas fa-globe text-purple-400 mt-1 mr-3 w-5"></i>
                                    <div class="text-white font-medium">Hybrid Event</div>
                                @else
                                    <i class="fas fa-users text-green-400 mt-1 mr-3 w-5"></i>
                                    <div class="text-white font-medium">In-Person Event</div>
                                @endif
                            </div>
                            
                            <!-- Category -->
                            <div class="flex items-start">
                                <i class="fas fa-tag text-yellow-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                          style="background-color: {{ $event->category->color ?? '#6B7280' }}20; color: {{ $event->category->color ?? '#6B7280' }};">
                                        {{ $event->category->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Events -->
                    @if($relatedEvents->count() > 0)
                        <div class="glass rounded-2xl p-6 animate-on-scroll">
                            <h3 class="text-xl font-bold text-white mb-6">Related Events</h3>
                            <div class="space-y-4">
                                @foreach($relatedEvents as $related)
                                    <div class="gradient-card rounded-lg p-4 hover:bg-white/10 transition-all duration-300">
                                        <h4 class="text-white font-medium mb-2 line-clamp-2">
                                            <a href="{{ route('events.show', $related) }}" class="hover:text-gray-300 transition-colors duration-300">
                                                {{ $related->name }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center text-gray-400 text-sm mb-2">
                                            <i class="fas fa-calendar mr-2"></i>
                                            {{ $related->start_date->format('M d, Y') }}
                                        </div>
                                        <a href="{{ route('events.show', $related) }}" 
                                           class="text-blue-400 hover:text-blue-300 text-sm transition-colors duration-300">
                                            Learn More <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $event->name }}',
                text: '{{ Str::limit($event->description, 100) }}',
                url: window.location.href
            });
        } else {
            // Fallback to copying URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Event link copied to clipboard!');
            });
        }
    }
</script>
@endpush

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection