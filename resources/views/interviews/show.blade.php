@extends('layouts.public')

@section('title', $interview->title . ' - Interviews - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Interview Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <!-- Background Image -->
        @if($interview->image)
            <div class="absolute inset-0">
                <img src="{{ asset('img/' . $interview->image) }}" 
                     alt="{{ $interview->title }}" 
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
                        <li><a href="{{ route('interviews.index') }}" class="text-gray-300 hover:text-white transition-colors duration-300">Interviews</a></li>
                        <li><span class="text-gray-500">/</span></li>
                        <li class="text-white">{{ Str::limit($interview->title, 30) }}</li>
                    </ol>
                </nav>
                
                <!-- Interview Info -->
                <div class="animate-fade-in-up">
                    <!-- Category & Featured Badge -->
                    <div class="flex items-center gap-4 mb-6">
                        <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full" 
                              style="background-color: {{ $interview->category->color ?? '#6B7280' }}; color: white;">
                            {{ $interview->category->name }}
                        </span>
                        
                      
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        {{ $interview->title }}
                    </h1>
                    
                    <!-- Guest Info -->
                    @if($interview->candidate_name)
                        <div class="flex items-center mb-6">
                            
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ $interview->candidate_name }}</h2>
                                @if($interview->position)
                                    <p class="text-gray-300">{{ $interview->position }}</p>
                                @endif
                                @if($interview->candidate_company)
                                    <p class="text-gray-400 text-sm">{{ $interview->candidate_company }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Interview Meta -->
                    <div class="flex flex-wrap gap-6 text-gray-300 mb-8">
                        <!-- Published Date -->
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-3 text-xl"></i>
                            <div>
                                <div class="font-medium">
                                    {{ $interview->published_at ? $interview->published_at->format('F j, Y') : 'Not Published' }}
                                </div>
                            </div>
                        </div>
                        
                     
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 mb-8">
                      
                        
                        <button onclick="shareInterview()" 
                                class="px-8 py-4 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-share mr-2"></i>
                            Share Interview
                        </button>
                    </div>
                    
                  
                </div>
            </div>
        </div>
    </section>

    <!-- Interview Content -->
    <section class="py-16  lg:px-40">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Video Embed or Placeholder -->
                   
                    
                    <!-- Interview Content -->
                    <div class="glass rounded-2xl p-8 animate-on-scroll">
                        <h3 class="text-3xl font-bold text-white mb-6">Content</h3>

                        @if($interview->description)
                            <div class="prose prose-invert max-w-none">
                                <div class="text-gray-300 leading-relaxed text-lg">
                                    {!! nl2br(e($interview->description)) !!}
                                </div>
                            </div>
                        @else
                            <p class="text-gray-300 text-lg leading-relaxed">
                                Join us for an insightful conversation with {{ $interview->candidate_name ?? 'our guest' }} 
                                as we explore {{ strtolower($interview->category->name ?? 'various topics') }} and gain valuable insights 
                                from their experience and expertise.
                            </p>
                        @endif
                        
                        <!-- Key Topics/Tags -->
                        
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Interview Details Card -->
                    <div class="glass rounded-2xl p-6 mb-8 animate-on-scroll">
                        <h3 class="text-xl font-bold text-white mb-6">Interview Details</h3>
                        
                        <div class="space-y-4">
                            <!-- Guest Info -->
                            @if($interview->candidate_name)
                                <div class="flex items-start">
                                    <i class="fas fa-user text-blue-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">{{ $interview->candidate_name }}</div>
                                        @if($interview->position)
                                            <div class="text-gray-400 text-sm">{{ $interview->position }}</div>
                                        @endif
                                        @if($interview->guest_company)
                                            <div class="text-gray-400 text-sm">{{ $interview->title }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Published Date -->
                            <div class="flex items-start">
                                <i class="fas fa-calendar text-green-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <div class="text-white font-medium">
                                        {{ $interview->published_at ? $interview->published_at->format('F j, Y') : 'Coming Soon' }}
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            <!-- Category -->
                            <div class="flex items-start">
                                <i class="fas fa-tag text-purple-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                          style="background-color: {{ $interview->category->color ?? '#6B7280' }}20; color: {{ $interview->category->color ?? '#6B7280' }};">
                                        {{ $interview->category->name }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Video Link -->
                            
                        </div>
                    </div>
                    
                    <!-- Related Interviews -->
                    @if($relatedInterviews->count() > 0)
                        <div class="glass rounded-2xl p-6 animate-on-scroll">
                            <h3 class="text-xl font-bold text-white mb-6">Related Interviews</h3>
                            <div class="space-y-4">
                                @foreach($relatedInterviews as $related)
                                    <div class="gradient-card rounded-lg p-4 hover:bg-white/10 transition-all duration-300">
                                        <h4 class="text-white font-medium mb-2 line-clamp-2">
                                            <a href="{{ route('interviews.show', $related) }}" class="hover:text-gray-300 transition-colors duration-300">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        @if($related->guest_name)
                                            <div class="flex items-center text-gray-400 text-sm mb-2">
                                                <i class="fas fa-user mr-2"></i>
                                                {{ $related->guest_name }}
                                            </div>
                                        @endif
                                        <a href="{{ route('interviews.show', $related) }}" 
                                           class="text-blue-400 hover:text-blue-300 text-sm transition-colors duration-300">
                                            Watch Interview <i class="fas fa-arrow-right ml-1"></i>
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
    function shareInterview() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $interview->title }}',
                text: '{{ Str::limit($interview->description, 100) }}',
                url: window.location.href
            });
        } else {
            // Fallback to copying URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Interview link copied to clipboard!');
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