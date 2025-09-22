@extends('layouts.public')

@section('title', $podcast->title . ' - Podcasts - The Vision')

@section('content')
<div class="min-h-screen">
    <!-- Podcast Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <!-- Background Image -->
        @if($podcast->image)
            <div class="absolute inset-0">
                <img src="{{ asset('img/' . $podcast->image) }}" 
                     alt="{{ $podcast->title }}" 
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
                        <li><a href="{{ route('podcasts.index') }}" class="text-gray-300 hover:text-white transition-colors duration-300">Podcasts</a></li>
                        <li><span class="text-gray-500">/</span></li>
                        <li class="text-white">{{ Str::limit($podcast->title, 30) }}</li>
                    </ol>
                </nav>
                
                <!-- Podcast Info -->
                <div class="animate-fade-in-up">
                    <!-- Category & Featured Badge -->
                    <div class="flex items-center gap-4 mb-6">
                        <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full" 
                              style="background-color: {{ $podcast->category->color ?? '#6B7280' }}; color: white;">
                            {{ $podcast->category->name }}
                        </span>
                        
                        @if($podcast->is_featured)
                            <span class="inline-block px-4 py-2 text-sm font-semibold bg-yellow-500 text-black rounded-full">
                                <i class="fas fa-star mr-1"></i>Featured Episode
                            </span>
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        {{ $podcast->title }}
                    </h1>
                    
                    <!-- Host Info -->
                    @if($podcast->host_name)
                        <div class="flex items-center mb-6">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full flex items-center justify-center mr-4">
                                @if($podcast->host_image)
                                    <img src="{{ asset('img/' . $podcast->host_image) }}" 
                                         alt="{{ $podcast->host_name }}" 
                                         class="w-full h-full object-cover rounded-full">
                                @else
                                    <i class="fas fa-microphone text-white text-xl"></i>
                                @endif
                            </div>
                            <div>
                                <p class="text-gray-300 text-sm">Hosted by</p>
                                <h2 class="text-xl font-bold text-white">{{ $podcast->host_name }}</h2>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Podcast Meta -->
                    <div class="flex flex-wrap gap-6 text-gray-300 mb-8">
                        <!-- Published Date -->
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-3 text-xl"></i>
                            <div>
                                <div class="font-medium">
                                    {{ $podcast->published_at ? $podcast->published_at->format('F j, Y') : 'Not Published' }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Duration -->
                        @if($podcast->duration)
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-3 text-xl"></i>
                                <div>
                                    <div class="font-medium">{{ $podcast->duration }} minutes</div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Audio Available -->
                        @if($podcast->audio_file)
                            <div class="flex items-center">
                                <i class="fas fa-volume-up mr-3 text-xl text-green-400"></i>
                                <span class="font-medium">Audio Available</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        @if($podcast->audio_file)
                            <button id="mainPlayButton" 
                                    class="btn-gradient px-8 py-4 rounded-lg font-medium text-lg inline-flex items-center"
                                    data-audio="{{ asset('audio/' . $podcast->audio_file) }}"
                                    data-title="{{ $podcast->title }}">
                                <i class="fas fa-play mr-2"></i>
                                <span class="play-text">Play Episode</span>
                            </button>
                        @endif
                        
                        <button onclick="sharePodcast()" 
                                class="px-8 py-4 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-share mr-2"></i>
                            Share Episode
                        </button>
                        
                        @if($podcast->audio_file)
                            <a href="{{ asset('audio/' . $podcast->audio_file) }}" 
                               download 
                               class="px-8 py-4 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300 inline-flex items-center">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        @endif
                    </div>
                    
                    <!-- Description -->
                    <p class="text-lg text-gray-300 leading-relaxed">{{ $podcast->description }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Audio Player Section -->
    @if($podcast->audio_file)
        <section class="py-8 bg-black/20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="glass rounded-2xl p-8 animate-on-scroll">
                        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                            <i class="fas fa-headphones mr-3 text-purple-400"></i>
                            Audio Player
                        </h3>
                        
                        <!-- Custom Audio Player -->
                        <div id="customAudioPlayer" class="bg-white/5 rounded-xl p-6 border border-white/10">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <button id="playPauseBtn" class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center hover:bg-purple-400 transition-colors duration-300 mr-4">
                                        <i class="fas fa-play text-white ml-1"></i>
                                    </button>
                                    <div>
                                        <div class="text-white font-medium">{{ $podcast->title }}</div>
                                        <div class="text-gray-400 text-sm">{{ $podcast->host_name ?? 'The Vision Podcast' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <span id="currentTime">0:00</span>
                                    <span class="mx-2">/</span>
                                    <span id="totalTime">0:00</span>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="w-full bg-white/20 rounded-full h-2 cursor-pointer" id="progressBar">
                                    <div id="progress" class="bg-gradient-to-r from-purple-400 to-pink-400 h-2 rounded-full w-0 transition-all duration-300"></div>
                                </div>
                            </div>
                            
                            <!-- Controls -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <button id="rewind15" class="text-gray-400 hover:text-white transition-colors duration-300">
                                        <i class="fas fa-undo"></i> 15s
                                    </button>
                                    <button id="forward15" class="text-gray-400 hover:text-white transition-colors duration-300">
                                        15s <i class="fas fa-redo"></i>
                                    </button>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-volume-down text-gray-400 mr-2"></i>
                                        <input type="range" id="volumeSlider" min="0" max="100" value="100" 
                                               class="w-20 h-2 bg-white/20 rounded-full appearance-none cursor-pointer">
                                    </div>
                                    <button id="muteBtn" class="text-gray-400 hover:text-white transition-colors duration-300">
                                        <i class="fas fa-volume-up"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden Audio Element -->
                        <audio id="audioElement" preload="metadata">
                            <source src="{{ asset('audio/' . $podcast->audio_file) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Podcast Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Podcast Content -->
                    <div class="glass rounded-2xl p-8 animate-on-scroll">
                        <h3 class="text-3xl font-bold text-white mb-6">About This Episode</h3>
                        
                        @if($podcast->content)
                            <div class="prose prose-invert max-w-none">
                                <div class="text-gray-300 leading-relaxed text-lg">
                                    {!! nl2br(e($podcast->content)) !!}
                                </div>
                            </div>
                        @else
                            <p class="text-gray-300 text-lg leading-relaxed">
                                Join us for this engaging episode featuring insightful discussions about 
                                {{ strtolower($podcast->category->name ?? 'various topics') }}. 
                                Our host {{ $podcast->host_name ?? 'explores' }} brings you valuable insights and expert perspectives.
                            </p>
                        @endif
                        
                        <!-- Show Notes/Tags -->
                        @if($podcast->show_notes)
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <h4 class="text-lg font-semibold text-white mb-4">Show Notes</h4>
                                <div class="text-gray-300 leading-relaxed">
                                    {!! nl2br(e($podcast->show_notes)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Episode Details Card -->
                    <div class="glass rounded-2xl p-6 mb-8 animate-on-scroll">
                        <h3 class="text-xl font-bold text-white mb-6">Episode Details</h3>
                        
                        <div class="space-y-4">
                            <!-- Host Info -->
                            @if($podcast->host_name)
                                <div class="flex items-start">
                                    <i class="fas fa-microphone text-purple-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">{{ $podcast->host_name }}</div>
                                        <div class="text-gray-400 text-sm">Host</div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Published Date -->
                            <div class="flex items-start">
                                <i class="fas fa-calendar text-green-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <div class="text-white font-medium">
                                        {{ $podcast->published_at ? $podcast->published_at->format('F j, Y') : 'Coming Soon' }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Duration -->
                            @if($podcast->duration)
                                <div class="flex items-start">
                                    <i class="fas fa-clock text-yellow-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">{{ $podcast->duration }} minutes</div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Category -->
                            <div class="flex items-start">
                                <i class="fas fa-tag text-blue-400 mt-1 mr-3 w-5"></i>
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                          style="background-color: {{ $podcast->category->color ?? '#6B7280' }}20; color: {{ $podcast->category->color ?? '#6B7280' }};">
                                        {{ $podcast->category->name }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Audio File -->
                            @if($podcast->audio_file)
                                <div class="flex items-start">
                                    <i class="fas fa-file-audio text-pink-400 mt-1 mr-3 w-5"></i>
                                    <div>
                                        <div class="text-white font-medium">Audio Available</div>
                                        <a href="{{ asset('audio/' . $podcast->audio_file) }}" 
                                           download 
                                           class="text-blue-400 hover:text-blue-300 text-sm transition-colors duration-300">
                                            Download Episode <i class="fas fa-download ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Related Episodes -->
                    @if($relatedPodcasts->count() > 0)
                        <div class="glass rounded-2xl p-6 animate-on-scroll">
                            <h3 class="text-xl font-bold text-white mb-6">Related Episodes</h3>
                            <div class="space-y-4">
                                @foreach($relatedPodcasts as $related)
                                    <div class="gradient-card rounded-lg p-4 hover:bg-white/10 transition-all duration-300">
                                        <h4 class="text-white font-medium mb-2 line-clamp-2">
                                            <a href="{{ route('podcasts.show', $related) }}" class="hover:text-gray-300 transition-colors duration-300">
                                                {{ $related->title }}
                                            </a>
                                        </h4>
                                        @if($related->host_name)
                                            <div class="flex items-center text-gray-400 text-sm mb-2">
                                                <i class="fas fa-microphone mr-2"></i>
                                                {{ $related->host_name }}
                                            </div>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('podcasts.show', $related) }}" 
                                               class="text-purple-400 hover:text-purple-300 text-sm transition-colors duration-300">
                                                Listen <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                            @if($related->duration)
                                                <span class="text-gray-500 text-xs">{{ $related->duration }} min</span>
                                            @endif
                                        </div>
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
    let audio = document.getElementById('audioElement');
    let playPauseBtn = document.getElementById('playPauseBtn');
    let mainPlayButton = document.getElementById('mainPlayButton');
    let progressBar = document.getElementById('progressBar');
    let progress = document.getElementById('progress');
    let currentTimeSpan = document.getElementById('currentTime');
    let totalTimeSpan = document.getElementById('totalTime');
    let volumeSlider = document.getElementById('volumeSlider');
    let muteBtn = document.getElementById('muteBtn');
    let rewind15Btn = document.getElementById('rewind15');
    let forward15Btn = document.getElementById('forward15');
    
    // Initialize audio player
    if (audio) {
        // Load metadata
        audio.addEventListener('loadedmetadata', function() {
            totalTimeSpan.textContent = formatTime(audio.duration);
        });
        
        // Update progress
        audio.addEventListener('timeupdate', function() {
            const progressPercent = (audio.currentTime / audio.duration) * 100;
            progress.style.width = progressPercent + '%';
            currentTimeSpan.textContent = formatTime(audio.currentTime);
        });
        
        // Play/Pause events
        audio.addEventListener('play', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-pause text-white"></i>';
            if (mainPlayButton) {
                mainPlayButton.innerHTML = '<i class="fas fa-pause mr-2"></i><span class="play-text">Pause Episode</span>';
            }
        });
        
        audio.addEventListener('pause', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-play text-white ml-1"></i>';
            if (mainPlayButton) {
                mainPlayButton.innerHTML = '<i class="fas fa-play mr-2"></i><span class="play-text">Play Episode</span>';
            }
        });
        
        // Play/Pause button clicks
        playPauseBtn.addEventListener('click', togglePlayPause);
        if (mainPlayButton) {
            mainPlayButton.addEventListener('click', togglePlayPause);
        }
        
        // Progress bar click
        progressBar.addEventListener('click', function(e) {
            const rect = progressBar.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            const width = rect.width;
            const clickPercent = clickX / width;
            audio.currentTime = clickPercent * audio.duration;
        });
        
        // Volume controls
        volumeSlider.addEventListener('input', function() {
            audio.volume = volumeSlider.value / 100;
            updateVolumeIcon();
        });
        
        muteBtn.addEventListener('click', function() {
            audio.muted = !audio.muted;
            updateVolumeIcon();
        });
        
        // Rewind/Forward buttons
        rewind15Btn.addEventListener('click', function() {
            audio.currentTime = Math.max(0, audio.currentTime - 15);
        });
        
        forward15Btn.addEventListener('click', function() {
            audio.currentTime = Math.min(audio.duration, audio.currentTime + 15);
        });
    }
    
    function togglePlayPause() {
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    }
    
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
    
    function updateVolumeIcon() {
        if (audio.muted || audio.volume === 0) {
            muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
        } else if (audio.volume < 0.5) {
            muteBtn.innerHTML = '<i class="fas fa-volume-down"></i>';
        } else {
            muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
        }
    }
    
    function sharePodcast() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $podcast->title }}',
                text: '{{ Str::limit($podcast->description, 100) }}',
                url: window.location.href
            });
        } else {
            // Fallback to copying URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Podcast link copied to clipboard!');
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
    
    /* Custom range slider styles */
    input[type="range"] {
        -webkit-appearance: none;
        background: transparent;
        cursor: pointer;
    }
    
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    
    input[type="range"]::-moz-range-thumb {
        height: 16px;
        width: 16px;
        border-radius: 50%;
        background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush
@endsection