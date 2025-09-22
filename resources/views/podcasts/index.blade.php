@extends('layouts.public')

@section('title', 'Podcasts - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    Inspiring <span class="bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-400">Podcasts</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-12">
                    Listen to thought-provoking conversations, expert insights, and inspiring stories that shape the future.
                </p>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    <!-- Total Interviews -->
                    <div class="glass rounded-xl p-6 flex flex-col items-center animate-on-scroll">
                        <div class="text-4xl font-extrabold text-white mb-2">
                            <i class="fas fa-microphone-alt text-blue-400 mr-2"></i>{{ $podcasts->total() }}
                        </div>
                        <div class="text-gray-300 text-lg font-medium">Total Podcasts</div>
                    </div>
                    <!-- Categories -->
                    <div class="glass rounded-xl p-6 flex flex-col items-center animate-on-scroll">
                        <div class="text-4xl font-extrabold text-purple-400 mb-2">
                            <i class="fas fa-layer-group text-purple-300 mr-2"></i>{{ $categories->count() }}
                        </div>
                        <div class="text-gray-300 text-lg font-medium">Categories</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters and Search -->
    <section class="py-12 bg-black/20">
        <div class="container mx-auto px-4">
            <form method="GET" action="{{ route('podcasts.index') }}" class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label for="search" class="block text-gray-300 font-medium mb-2">Search Podcasts</label>
                        <div class="relative">
                            <input type="text" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search by title, host, or topic..." 
                                   class="w-full px-4 py-3 pl-12 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-gray-300 font-medium mb-2">Category</label>
                        <select name="category" 
                                id="category" 
                                class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300">
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
                        <a href="{{ route('podcasts.index') }}" 
                           class="inline-block text-sm text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fas fa-times-circle mr-1"></i>Clear Filters
                        </a>
                    @endif
                </div>
                
                
            </form>
        </div>
    </section>

    <!-- Podcasts Grid -->
    <section class="py-16 px-12">
        <div class="container mx-auto px-4">
            @if($podcasts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($podcasts as $podcast)
                        <article class="podcast-card group cursor-pointer animate-on-scroll" 
                                 onclick="location.href='{{ route('podcasts.show', $podcast) }}'">
                            <div class="glass rounded-2xl overflow-hidden hover:bg-white/10 transition-all duration-500 hover:scale-105 h-full">
                                <!-- Image -->
                                <div class="relative aspect-square overflow-hidden">
                                    @if($podcast->image)
                                        <img src="{{ asset('img/' . $podcast->image) }}" 
                                             alt="{{ $podcast->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                                            <i class="fas fa-podcast text-4xl text-white/80"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full text-white"
                                              style="background-color: {{ $podcast->category->color ?? '#6B7280' }};">
                                            {{ $podcast->category->name }}
                                        </span>
                                    </div>
                                    
                                    <!-- Featured Badge -->
                                    @if($podcast->is_featured)
                                        <div class="absolute top-4 right-4">
                                            <span class="px-3 py-1 text-xs font-semibold bg-yellow-500 text-black rounded-full">
                                                <i class="fas fa-star mr-1"></i>Featured
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Play Overlay -->
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/30">
                                            <i class="fas fa-play text-white text-xl ml-1"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Audio Available Indicator -->
                                    @if($podcast->audio_file)
                                        <div class="absolute bottom-4 left-4">
                                            <span class="flex items-center px-3 py-1 bg-green-500/80 text-white text-xs rounded-full">
                                                <i class="fas fa-volume-up mr-1"></i>Audio Available
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <!-- Host Info -->
                                    @if($podcast->host_name)
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-microphone text-purple-400 mr-2"></i>
                                            <span class="text-gray-300 text-sm font-medium">Hosted by {{ $podcast->host_name }}</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-gray-200 transition-colors duration-300">
                                        {{ $podcast->title }}
                                    </h3>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">
                                        {{ $podcast->description }}
                                    </p>
                                    
                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <span>{{ $podcast->published_at ? $podcast->published_at->format('M d, Y') : 'Draft' }}</span>
                                        </div>
                                        
                                        @if($podcast->duration)
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                <span>{{ $podcast->duration }} min</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Audio Player Preview -->
                                    @if($podcast->audio_file)
                                        <div class="mb-4">
                                            <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg border border-white/10">
                                                <div class="flex items-center">
                                                    <button class="play-btn w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center hover:bg-purple-400 transition-colors duration-300" 
                                                            data-audio="{{ asset('audio/' . $podcast->audio_file) }}">
                                                        <i class="fas fa-play text-white text-xs ml-0.5"></i>
                                                    </button>
                                                    <span class="text-gray-300 text-xs ml-2">Preview</span>
                                                </div>
                                                <div class="text-gray-400 text-xs">
                                                    <i class="fas fa-headphones mr-1"></i>Audio
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Listen Button -->
                                    <div class="pt-4 border-t border-white/10">
                                        <div class="flex items-center text-purple-400 group-hover:text-purple-300 transition-colors duration-300 text-sm font-medium">
                                            <span>Listen to Episode</span>
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($podcasts->hasPages())
                    <div class="mt-16 flex justify-center animate-on-scroll">
                        <div class="glass rounded-xl px-6 py-4">
                            {{ $podcasts->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-20 animate-fade-in-up">
                    <div class="glass rounded-2xl p-12 max-w-lg mx-auto">
                        <i class="fas fa-podcast text-6xl text-gray-400 mb-6"></i>
                        <h3 class="text-2xl font-bold text-white mb-4">No Podcasts Found</h3>
                        <p class="text-gray-400 mb-6">
                            @if(request()->hasAny(['search', 'category', 'featured']))
                                No podcasts match your current filters. Try adjusting your search criteria.
                            @else
                                We're working on bringing you amazing podcast content. Check back soon!
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'category', 'featured']))
                            <a href="{{ route('podcasts.index') }}" 
                               class="btn-gradient px-6 py-3 rounded-lg font-medium inline-flex items-center">
                                <i class="fas fa-refresh mr-2"></i>View All Podcasts
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Global Audio Player -->
    <div id="globalAudioPlayer" class="fixed bottom-4 left-4 right-4 md:left-8 md:right-8 bg-black/90 backdrop-blur-sm border border-white/20 rounded-lg p-4 transform translate-y-full opacity-0 transition-all duration-300 z-50">
        <div class="flex items-center justify-between">
            <div class="flex items-center flex-1">
                <button id="globalPlayBtn" class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center hover:bg-purple-400 transition-colors duration-300 mr-4">
                    <i class="fas fa-play text-white ml-0.5"></i>
                </button>
                <div class="flex-1">
                    <div id="globalPlayerTitle" class="text-white font-medium text-sm"></div>
                    <div class="w-full bg-white/20 rounded-full h-1 mt-2">
                        <div id="globalPlayerProgress" class="bg-purple-500 h-1 rounded-full w-0 transition-all duration-300"></div>
                    </div>
                </div>
            </div>
            <button id="globalCloseBtn" class="text-gray-400 hover:text-white ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
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
    
    /* Custom checkbox styles */
    input[type="checkbox"]:checked + div {
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
    }
    
    input[type="checkbox"]:checked + div .dot {
        transform: translateX(100%);
        background-color: white;
    }
    
    .podcast-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .podcast-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    let currentAudio = null;
    let globalPlayer = document.getElementById('globalAudioPlayer');
    let globalPlayBtn = document.getElementById('globalPlayBtn');
    let globalPlayerTitle = document.getElementById('globalPlayerTitle');
    let globalPlayerProgress = document.getElementById('globalPlayerProgress');
    let globalCloseBtn = document.getElementById('globalCloseBtn');
    
    // Auto-submit form on checkbox change
    document.querySelector('input[name="featured"]').addEventListener('change', function() {
        this.closest('form').submit();
    });
    
    // Handle play button clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.play-btn')) {
            e.stopPropagation();
            const btn = e.target.closest('.play-btn');
            const audioUrl = btn.dataset.audio;
            const podcastCard = btn.closest('.podcast-card');
            const podcastTitle = podcastCard.querySelector('h3').textContent;
            
            playAudio(audioUrl, podcastTitle, btn);
        }
    });
    
    // Global player controls
    globalPlayBtn.addEventListener('click', function() {
        if (currentAudio) {
            if (currentAudio.paused) {
                currentAudio.play();
            } else {
                currentAudio.pause();
            }
        }
    });
    
    globalCloseBtn.addEventListener('click', function() {
        if (currentAudio) {
            currentAudio.pause();
            currentAudio = null;
        }
        hideGlobalPlayer();
    });
    
    function playAudio(url, title, button) {
        // Stop current audio if playing
        if (currentAudio) {
            currentAudio.pause();
            currentAudio = null;
        }
        
        // Create new audio
        currentAudio = new Audio(url);
        globalPlayerTitle.textContent = title;
        
        // Show global player
        showGlobalPlayer();
        
        // Update button states
        updatePlayButtons();
        
        // Audio event listeners
        currentAudio.addEventListener('play', function() {
            globalPlayBtn.innerHTML = '<i class="fas fa-pause text-white"></i>';
            button.innerHTML = '<i class="fas fa-pause text-white text-xs"></i>';
        });
        
        currentAudio.addEventListener('pause', function() {
            globalPlayBtn.innerHTML = '<i class="fas fa-play text-white ml-0.5"></i>';
            button.innerHTML = '<i class="fas fa-play text-white text-xs ml-0.5"></i>';
        });
        
        currentAudio.addEventListener('timeupdate', function() {
            const progress = (currentAudio.currentTime / currentAudio.duration) * 100;
            globalPlayerProgress.style.width = progress + '%';
        });
        
        currentAudio.addEventListener('ended', function() {
            hideGlobalPlayer();
            updatePlayButtons();
        });
        
        // Start playing
        currentAudio.play();
    }
    
    function showGlobalPlayer() {
        globalPlayer.style.transform = 'translateY(0)';
        globalPlayer.style.opacity = '1';
    }
    
    function hideGlobalPlayer() {
        globalPlayer.style.transform = 'translateY(100%)';
        globalPlayer.style.opacity = '0';
    }
    
    function updatePlayButtons() {
        document.querySelectorAll('.play-btn').forEach(btn => {
            btn.innerHTML = '<i class="fas fa-play text-white text-xs ml-0.5"></i>';
        });
    }
    
    // Smooth scroll animation observer
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-visible');
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-on-scroll').forEach(function(element) {
            observer.observe(element);
        });
    });
</script>
@endpush
@endsection