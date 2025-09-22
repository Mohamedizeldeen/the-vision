@extends('layouts.public')

@section('title', 'Interviews - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-gray-900 to-black"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                    Inspiring <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-400">Interviews</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto mb-12">
                    Discover powerful conversations with visionary leaders, entrepreneurs, and changemakers who are shaping our future.
                </p>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
                    <!-- Total Interviews -->
                    <div class="glass rounded-xl p-6 flex flex-col items-center animate-on-scroll">
                        <div class="text-4xl font-extrabold text-white mb-2">
                            <i class="fas fa-microphone-alt text-blue-400 mr-2"></i>{{ $interviews->total() }}
                        </div>
                        <div class="text-gray-300 text-lg font-medium">Total Interviews</div>
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
            <form method="GET" action="{{ route('interviews.index') }}" class="max-w-6xl mx-auto">
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
                        <a href="{{ route('interviews.index') }}" 
                           class="inline-block text-sm text-gray-400 hover:text-white transition-colors duration-300">
                            <i class="fas fa-times-circle mr-1"></i>Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <!-- Interviews Grid -->
    <section class="py-16 px-12">
        <div class="container mx-auto px-4">
            @if($interviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($interviews as $interview)
                        <article class="interview-card group cursor-pointer animate-on-scroll" 
                                 onclick="location.href='{{ route('interviews.show', $interview) }}'">
                            <div class="glass rounded-2xl overflow-hidden hover:bg-white/10 transition-all duration-500 hover:scale-105 h-full">
                                <!-- Image -->
                                <div class="relative aspect-video overflow-hidden">
                                    @if($interview->image)
                                        <img src="{{ asset('img/' . $interview->image) }}" 
                                             alt="{{ $interview->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center">
                                            <i class="fas fa-microphone text-4xl text-white/80"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full text-white"
                                              style="background-color: {{ $interview->category->color ?? '#6B7280' }};">
                                            {{ $interview->category->name }}
                                        </span>
                                    </div>
                                    
                                    <!-- Featured Badge -->
                                    @if($interview->is_featured)
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
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <!-- Guest Info -->
                                    @if($interview->guest_name)
                                        <div class="flex items-center mb-3">
                                            <i class="fas fa-user-circle text-blue-400 mr-2"></i>
                                            <span class="text-gray-300 text-sm font-medium">{{ $interview->guest_name }}</span>
                                            @if($interview->guest_title)
                                                <span class="text-gray-400 text-sm ml-2">• {{ $interview->guest_title }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <!-- Title -->
                                    <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-gray-200 transition-colors duration-300">
                                        {{ $interview->title }}
                                    </h3>
                                    
                                    <!-- Description -->
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">
                                        {{ $interview->description }}
                                    </p>
                                    
                                    <!-- Meta Info -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <span>{{ $interview->published_at ? $interview->published_at->format('M d, Y') : 'Draft' }}</span>
                                        </div>
                                        
                                        @if($interview->duration)
                                            <div class="flex items-center">
                                                <i class="fas fa-clock mr-1"></i>
                                                <span>{{ $interview->duration }} min</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Read More Button -->
                                    <div class="mt-4 pt-4 border-t border-white/10">
                                        <div class="flex items-center text-blue-400 group-hover:text-blue-300 transition-colors duration-300 text-sm font-medium">
                                            <span>Watch Interview</span>
                                            <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($interviews->hasPages())
                    <div class="mt-16 flex justify-center animate-on-scroll">
                        <div class="glass rounded-xl px-6 py-4">
                            {{ $interviews->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-20 animate-fade-in-up">
                    <div class="glass rounded-2xl p-12 max-w-lg mx-auto">
                        <i class="fas fa-microphone text-6xl text-gray-400 mb-6"></i>
                        <h3 class="text-2xl font-bold text-white mb-4">No Interviews Found</h3>
                        <p class="text-gray-400 mb-6">
                            @if(request()->hasAny(['search', 'category', 'featured']))
                                No interviews match your current filters. Try adjusting your search criteria.
                            @else
                                We're working on bringing you inspiring interviews. Check back soon!
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'category', 'featured']))
                            <a href="{{ route('interviews.index') }}" 
                               class="btn-gradient px-6 py-3 rounded-lg font-medium inline-flex items-center">
                                <i class="fas fa-refresh mr-2"></i>View All Interviews
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
    
    /* Custom checkbox styles */
    input[type="checkbox"]:checked + div {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    input[type="checkbox"]:checked + div .dot {
        transform: translateX(100%);
        background-color: white;
    }
    
    .interview-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .interview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-submit form on checkbox change
    document.querySelector('input[name="featured"]').addEventListener('change', function() {
        this.closest('form').submit();
    });
    
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