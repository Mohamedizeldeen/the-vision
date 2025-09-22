<!-- Header -->
<header class="fixed top-0 left-0 right-0 z-50 glass">
    <div class="container mx-auto px-4 py-4">
        <div class="flex justify-between items-center">
            <div class="logo">
                <a href="/">
                    <img class="w-[100px] sm:w-[120px] animate-float" src="{{ asset('img/visionLogoWhite.png') }}" alt="The Vision">
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-6 lg:space-x-8">
                <a href="/" class="text-white nav-gradient-hover transition-all duration-300 font-normal relative group {{ request()->routeIs('home') || request()->is('/') ? 'text-gray-300' : '' }}">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full {{ request()->routeIs('home') || request()->is('/') ? 'w-full' : '' }}"></span>
                </a>
                <a href="{{ route('interviews.index') }}" class="text-white nav-gradient-hover transition-all duration-300 font-normal relative group {{ request()->routeIs('interviews.*') ? 'text-gray-300' : '' }}">
                    Interviews
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full {{ request()->routeIs('interviews.*') ? 'w-full' : '' }}"></span>
                </a>
                <a href="{{ route('events.index') }}" class="text-white nav-gradient-hover transition-all duration-300 font-normal relative group {{ request()->routeIs('events.*') ? 'text-gray-300' : '' }}">
                    Events
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full {{ request()->routeIs('events.*') ? 'w-full' : '' }}"></span>
                </a>
                <a href="{{ route('podcasts.index') }}" class="text-white nav-gradient-hover transition-all duration-300 font-normal relative group {{ request()->routeIs('podcasts.*') ? 'text-gray-300' : '' }}">
                    Podcasts
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full {{ request()->routeIs('podcasts.*') ? 'w-full' : '' }}"></span>
                </a>
                @if(request()->is('/'))
                    <a href="#about" class="text-white nav-gradient-hover transition-all duration-300 font-normal relative group">
                        About
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endif
            </nav>
            
            <!-- Desktop Action Button -->
            @if(request()->is('/'))
                <div class="hidden md:block">
                    <a href="#contact" class="btn-gradient px-4 py-2 rounded-full transition-all duration-300 shadow-md font-normal text-sm">
                        Contact Us
                    </a>
                </div>
            @else
                @auth
                    <div class="hidden md:block">
                        <a href="{{ route('admin.dashboard') }}" class="btn-gradient px-4 py-2 rounded-full transition-all duration-300 shadow-md font-normal text-sm">
                            <i class="fas fa-cog mr-2"></i>Admin Panel
                        </a>
                    </div>
                @else
                    <div class="hidden md:block">
                        <a href="{{ route('login') }}" class="btn-gradient px-4 py-2 rounded-full transition-all duration-300 shadow-md font-normal text-sm">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    </div>
                @endauth
            @endif
            
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-button md:hidden text-white relative z-50" type="button" id="mobile-menu-btn">
                <svg class="hamburger-icon w-6 h-6 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg class="close-icon w-6 h-6 transition-all duration-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div class="mobile-menu">
        <div class="flex flex-col items-center justify-center space-y-8 text-center w-full h-full px-6 py-8 min-h-screen">
            <a href="/" class="text-white text-2xl font-medium hover:text-gray-300 transition-all duration-300 {{ request()->routeIs('home') || request()->is('/') ? 'text-gray-300' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-home mr-3"></i>Home
            </a>
            <a href="{{ route('interviews.index') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition-all duration-300 {{ request()->routeIs('interviews.*') ? 'text-gray-300' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-microphone mr-3"></i>Interviews
            </a>
            <a href="{{ route('events.index') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition-all duration-300 {{ request()->routeIs('events.*') ? 'text-gray-300' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-calendar mr-3"></i>Events
            </a>
            <a href="{{ route('podcasts.index') }}" class="text-white text-2xl font-medium hover:text-gray-300 transition-all duration-300 {{ request()->routeIs('podcasts.*') ? 'text-gray-300' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-podcast mr-3"></i>Podcasts
            </a>
            
            @if(request()->is('/'))
                <a href="#about" class="text-white text-2xl font-medium hover:text-gray-300 transition-all duration-300" onclick="closeMobileMenu()">
                    <i class="fas fa-info-circle mr-3"></i>About
                </a>
            @endif
            
            <!-- Mobile Action Button -->
            <div class="pt-8 border-t border-gray-700 w-full">
                @if(request()->is('/'))
                    <a href="#contact" class="btn-gradient px-6 py-3 rounded-full transition-all duration-300 shadow-md font-medium text-lg inline-flex items-center" onclick="closeMobileMenu()">
                        Contact Us
                    </a>
                @else
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-gradient px-6 py-3 rounded-full transition-all duration-300 shadow-md font-medium text-lg inline-flex items-center" onclick="closeMobileMenu()">
                            <i class="fas fa-cog mr-2"></i>Admin Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-gradient px-6 py-3 rounded-full transition-all duration-300 shadow-md font-medium text-lg inline-flex items-center" onclick="closeMobileMenu()">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endauth
                @endif
            </div>
            
            <!-- Social Links -->
            <div class="flex space-x-6 pt-4">
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
            </div>
        </div>
    </div>
</header>