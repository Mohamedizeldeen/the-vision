<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Vision - Showcasing GCC Business Leaders</title>
    <link rel="icon" href="./img/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    @include('partials.navigation-styles')
    <style>
        /* Font family for headings */
        h1, h2, h3, h4, h5, h6, .hero-title {
            font-family: 'Raleway', sans-serif;
        }
        body{
            position: relative;
        }
        .country-tab {
                background: linear-gradient(135deg, rgba(17, 17, 17, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
                color: #000;
                border: 1px solid rgba(37, 52, 57, 0.2);
            }
            
            .country-tab.active {
                background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(19, 20, 20) 100%);
                color: white;
                border-color: #253439;
            }
            
            .country-tab:hover:not(.active) {
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.2) 0%, rgba(255, 255, 255, 1) 100%);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }
            
            .country-interviews {
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .country-interviews.active {
                opacity: 1;
            }
        
        .disabled { opacity: 0.5; cursor: not-allowed; }
        .smooth-scroll { scroll-behavior: smooth; }
        
        /* Modern animations and effects */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-pulse-custom {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Glass morphism effect */
        .glass {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: #000000;
            border: 1px solid #000000;
        }
        
        /* Modern gradient backgrounds */
        .gradient-bg-1 {
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(10, 10, 10) 100%);
        }
        
        .gradient-bg-2 {
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(0, 0, 0) 100%);
        }
        
        .gradient-bg-3 {
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%, #1e2a2e 100%);
        }
        
        /* Modern button hover effects */
        .btn-modern {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        /* Modern card hover effects */
        .card-modern {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }
        
        .card-modern:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        /* Modern text gradient */
        .text-gradient {
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(17, 22, 24) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Custom focus styles for brand color */
        .focus-brand:focus {
            border-color:rgb(0, 0, 0);
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 52, 57, 0.2);
        }
        
        /* Hero background with mobile-friendly handling */
        .hero-bg {
    /* background-image: linear-gradient(rgba(5, 5, 5, 0.7), rgba(0, 0, 0, 0.7)), url('./img/heroWellpaper.png'); */
    background: none;
    position: relative;
    overflow: hidden;
}
.hero-bg video.bg-video {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    object-fit: cover;
    z-index: 0;
    opacity: 0.7;
    pointer-events: none;
}
.hero-bg .container,
.hero-bg > .relative.z-10 {
    position: relative;
    z-index: 2;
}
        /* Desktop: Use fixed attachment for parallax effect */
        @media (min-width: 769px) and (hover: hover) {
            .hero-bg {
                background-attachment: fixed;
            }
        }
        
        /* Mobile: Use scroll attachment to avoid iOS issues */
        @media (max-width: 768px), (hover: none) {
            .hero-bg {
                background-attachment: scroll;
                /* Ensure better mobile performance */
                -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
            }
            
            /* Reduce hero section height on mobile */
            #home {
                min-height: 70vh !important;
            }
        }
        
        /* Extra small mobile devices */
        @media (max-width: 480px) {
            #home {
                min-height: 65vh !important;
                padding-top: 4rem !important;
                padding-bottom: 2rem !important;
            }
        }
        
        /* Navigation gradient hover effect */
        .nav-gradient-hover:hover {
            background: linear-gradient(135deg,rgb(253, 253, 253) 0%,rgb(255, 255, 255) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Header background when scrolled */
        .header-scrolled {
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Responsive typography */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem !important;
            }
        }
        
        /* Enhanced Responsive Design */
        @media (max-width: 640px) {
            .hero-title {
                font-size: 2.5rem !important;
                line-height: 1.2 !important;
                margin-bottom: 1.5rem !important;
            }
            
            .text-6xl, .text-5xl {
                font-size: 2.25rem !important;
            }
            
            .text-8xl {
                font-size: 3rem !important;
            }
            
            .py-24 {
                padding-top: 3rem !important;
                padding-bottom: 3rem !important;
            }
            
            .p-12 {
                padding: 1.5rem !important;
            }
            
            .px-10 {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
            
            .gap-6 {
                gap: 1rem !important;
            }
            
            .space-x-8 > * + * {
                margin-left: 1rem !important;
            }
            
            /* Hero section mobile adjustments */
            #home .container {
                padding-top: 2rem !important;
                padding-bottom: 1rem !important;
            }
            
            #home p {
                font-size: 1rem !important;
                margin-bottom: 2rem !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem !important;
            }
            
            .text-xl {
                font-size: 1.1rem !important;
            }
            
            .text-2xl {
                font-size: 1.25rem !important;
            }
            
            .px-6 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .py-4 {
                padding-top: 0.75rem !important;
                padding-bottom: 0.75rem !important;
            }
            
            .rounded-3xl {
                border-radius: 1rem !important;
            }
            
            .logo img {
                width: 120px !important;
            }
        }
        
        /* Mobile Navigation */
        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.95);
                backdrop-filter: blur(16px);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
                z-index: 50;
            }
            
            .mobile-menu.active {
                display: flex;
            }
            
            .mobile-menu-button {
                display: block;
                color: white;
                background: none;
                border: none;
                font-size: 1.5rem;
                cursor: pointer;
            }
            
            .mobile-menu a {
                color: white;
                text-decoration: none;
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
            }
            
            .mobile-menu a:hover {
                background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(27, 29, 29) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu-button {
                display: none;
            }
        }
        
        /* Card responsiveness */
        @media (max-width: 768px) {
            .card-modern {
                transform: none !important;
            }
            
            .card-modern:hover {
                transform: translateY(-5px) !important;
            }
        }
        
        /* FAQ mobile optimization */
        @media (max-width: 640px) {
            .faq-content {
                font-size: 0.9rem;
            }
                .country-tab {
                    font-size: 0.875rem;
                    padding: 0.5rem 1rem;
                }
            
            
            .px-8 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .py-6 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }
        
        /* Grid responsiveness */
        @media (max-width: 640px) {
            .grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }
        
        @media (max-width: 768px) {
            .md\:grid-cols-3 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
            
            .md\:grid-cols-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }
            
            .md\:grid-cols-2 {
                grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 smooth-scroll">
    @include('partials.navigation')

    <!-- Hero Section -->
    <section id="home" class="min-h-screen  pt-16 sm:pt-20 text-white relative overflow-hidden hero-bg">
        <!-- Dark overlay for better text readability -->
        <video class="bg-video" autoplay loop muted playsinline>
          <source src="{{ asset('video/Woman-in-Business.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
        </video>
        <div class="absolute inset-0 bg-black/20"></div>
        
        <div class="container mx-auto px-4 sm:px-6 py-12 sm:py-20 relative z-10">
            <div class="text-center animate-fade-in-up">
                <h1 class="hero-title text-4xl sm:text-6xl md:text-8xl font-bold mb-6 sm:mb-8 leading-tight">
                    Inspiring <span class="text-transparent bg-clip-text" style="background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(255, 255, 255) 100%); -webkit-background-clip: text; background-clip: text;">Journeys</span><br>
                    of <span class="text-transparent bg-clip-text" style="background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(255, 255, 255) 100%); -webkit-background-clip: text; background-clip: text;">GCC Leaders</span>
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-8 sm:mb-12 max-w-4xl mx-auto leading-relaxed opacity-90 px-4">
                    Showcasing the inspiring journeys of GCC businesses and leaders—highlighting the stories, values, and visions that define the region's progress and future legacy.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center items-center px-4">
                    <a href="#share-story" class="btn-modern bg-white px-6 sm:px-10 py-3 sm:py-4 rounded-full text-base sm:text-lg font-bold hover:scale-105 hover:shadow-2xl transition-all duration-300 shadow-xl w-full sm:w-auto" style="color: #253439;">
                        Share Your Story
                    </a>
                   
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media Sidebar -->
    <div class="fixed left-2 sm:left-4 top-1/2 transform -translate-y-1/2 z-40 flex flex-col space-y-3 sm:space-y-4">
        <a href="https://www.instagram.com/thevision.media.official_?igsh=MTZmcnRsNTNpbGVsNg%3D%3D&utm_source=qr" target="_blank" class="social-icon group relative">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg border border-white/20" style="background-color:rgb(83, 83, 83);">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white transition-all duration-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
            </div>
            <!-- Tooltip - Hidden on mobile -->
            <div class="hidden md:block absolute left-full ml-3 px-2 py-1 bg-black text-white text-xs lg:text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Follow us on Instagram
            </div>
        </a>
        
        <a href="https://www.linkedin.com/company/thevisionmedia/?viewAsMember=true" target="_blank" class="social-icon group relative">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg border border-white/20" style="background-color: rgb(83, 83, 83);">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white transition-all duration-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
            </div>
            <!-- Tooltip - Hidden on mobile -->
            <div class="hidden md:block absolute left-full ml-3 px-2 py-1 bg-black text-white text-xs lg:text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                Follow us on LinkedIn
            </div>
        </a>
    </div>

    <!-- About Us Section -->
    <section id="about" class="py-12 sm:py-16 md:py-24 bg-white relative">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(99,102,241,0.5) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center mb-12 sm:mb-16 md:mb-20 animate-fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6 sm:mb-8">
                    <span class="text-gradient">About Us</span>
                </h2>
                <div class="w-24 sm:w-32 h-1.5 mx-auto rounded-full" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(12, 13, 14) 100%);"></div>
            </div>
            <div class="max-w-5xl mx-auto">
                <div class="card-modern bg-gradient-to-br from-white to-gray-50 p-6 sm:p-8 md:p-12 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100">
                    <p class="text-lg sm:text-xl md:text-2xl text-gray-700 leading-relaxed text-center font-light">
                        We specialize in spotlighting the stories that matter—those that reflect 
                        <span class="font-semibold text-gradient">innovation</span>, 
                        <span class="font-semibold text-gradient">resilience</span>, and 
                        <span class="font-semibold text-gradient">ambition</span> across the Gulf. 
                        From emerging entrepreneurs to established industry icons, we showcase the people and enterprises driving meaningful progress across diverse sectors.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Examples Section -->
    <section id="projects" class="py-24 bg-gradient-to-br from-gray-50 to-blue-50 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 animate-fade-in-up">
                <h2 class="text-5xl md:text-6xl font-bold mb-8">
                    <span class="text-gradient">Our Projects</span>
                </h2>
                <div class="w-32 h-1.5 mx-auto rounded-full mb-8" style="background: linear-gradient(135deg,rgb(14, 15, 15) 0%,rgb(18, 20, 20) 100%);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto font-light">
                    Discover our featured publications and initiatives that celebrate excellence in business.
                </p>
            </div>
            
            <!-- Business Legacy Section -->
            <div class="card-modern bg-white rounded-3xl shadow-2xl p-12 md:p-16 max-w-6xl mx-auto relative overflow-hidden">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-200 to-blue-200 rounded-full -translate-y-16 translate-x-16 opacity-20"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-br from-pink-200 to-purple-200 rounded-full translate-y-12 -translate-x-12 opacity-20"></div>
                
                <div class="text-center mb-16 relative z-10">
                    <h3 class="text-4xl md:text-5xl font-bold mb-8">
                        <span class="text-gradient">Business Legacy</span>
                    </h3>
                    <div class="w-24 h-1 mx-auto rounded-full" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(13, 13, 14) 100%);"></div>
                </div>
                
                <div class="prose prose-xl mx-auto text-center relative z-10">
                    <p class="text-xl md:text-2xl text-gray-700 leading-relaxed mb-8 font-light">
                        Progress begins with <span class="font-semibold text-gradient">vision</span>—and is sustained by those bold enough to lead it. This edition quietly honors the individuals whose determination, values, and foresight have shaped the business landscape in lasting ways.
                    </p>
                    <p class="text-xl md:text-2xl text-gray-700 leading-relaxed font-light">
                        More than a reflection on success, it is an inspiration for what's next. A tribute to <span class="font-semibold text-gradient">legacy</span>, <span class="font-semibold text-gradient">leadership</span>, and the enduring power of purpose.
                    </p>
                </div>
                
             
            </div>
        </div>
    </section>

    <!-- What We Do Section -->
    <section id="services" class="py-12 sm:py-16 md:py-24 bg-white relative">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-12 sm:mb-16 md:mb-20 animate-fade-in-up">
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-6 sm:mb-8">
                    <span class="text-gradient">What We Do</span>
                </h2>
                <div class="w-24 sm:w-32 h-1.5 mx-auto rounded-full" style="background: linear-gradient(135deg, #253439 0%, #3a5158 100%);"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 md:gap-10 max-w-7xl mx-auto">
                <div class="card-modern text-center p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl hover:shadow-2xl transition-all duration-500 border relative overflow-hidden group" style="background: linear-gradient(135deg, rgba(37, 52, 57, 0.05) 0%, rgba(255, 255, 255, 1) 100%); border-color: rgba(37, 52, 57, 0.1);">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-all duration-500" style="background: linear-gradient(135deg, #253439 0%, #3a5158 100%);"></div>
                    <div class="w-16 h-16 sm:w-20 sm:h-20 gradient-bg-1 rounded-2xl flex items-center justify-center mx-auto mb-6 sm:mb-8 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Publishing</h3>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">Creating compelling narratives that showcase business excellence and leadership across the GCC region.</p>
                </div>
                
                <div class="card-modern text-center p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl hover:shadow-2xl transition-all duration-500 border relative overflow-hidden group" style="background: linear-gradient(135deg, rgba(37, 52, 57, 0.05) 0%, rgba(255, 255, 255, 1) 100%); border-color: rgba(37, 52, 57, 0.1);">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-all duration-500" style="background: linear-gradient(135deg, #253439 0%, #3a5158 100%);"></div>
                    <div class="w-16 h-16 sm:w-20 sm:h-20 gradient-bg-2 rounded-2xl flex items-center justify-center mx-auto mb-6 sm:mb-8 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Storytelling</h3>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">Capturing and sharing the inspiring journeys of businesses and leaders that shape our region's future.</p>
                </div>
                
                <div class="card-modern text-center p-6 sm:p-8 md:p-10 rounded-2xl sm:rounded-3xl hover:shadow-2xl transition-all duration-500 border relative overflow-hidden group" style="background: linear-gradient(135deg, rgba(37, 52, 57, 0.05) 0%, rgba(255, 255, 255, 1) 100%); border-color: rgba(37, 52, 57, 0.1);">
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-all duration-500" style="background: linear-gradient(135deg, #253439 0%, #3a5158 100%);"></div>
                    <div class="w-16 h-16 sm:w-20 sm:h-20 gradient-bg-3 rounded-2xl flex items-center justify-center mx-auto mb-6 sm:mb-8 group-hover:scale-110 transition-all duration-300">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Innovation Spotlight</h3>
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">Highlighting breakthrough innovations and visionary thinking that drives progress across diverse sectors.</p>
                </div>
            </div>
        </div>
    </section>
  
    <!-- Sponsors Section -->
    <section id="sponsors" class=" hidden py-24 bg-gradient-to-br from-gray-50 to-purple-50 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 animate-fade-in-up">
                <h2 class="text-5xl md:text-6xl font-bold mb-8">
                    <span class="text-gradient">Our Sponsors</span>
                </h2>
                <div class="w-32 h-1.5 mx-auto rounded-full mb-8" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(11, 12, 12) 100%);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-12 font-light">
                    We're proud to partner with leading organizations that share our vision of celebrating business excellence in the GCC region.
                </p>
                <button onclick="document.getElementById('contact').scrollIntoView({ behavior: 'smooth' })" class="btn-modern text-white px-12 py-4 rounded-full text-xl font-bold hover:scale-105 hover:shadow-2xl transition-all duration-300 shadow-xl" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(14, 15, 15) 100%);">
                    Learn More
                </button>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto hidden">
                <div class="card-modern bg-white p-8 rounded-2xl shadow-lg flex items-center justify-center h-32 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <span class="text-gray-400 text-sm font-medium">Sponsor Logo</span>
                </div>
                <div class="card-modern bg-white p-8 rounded-2xl shadow-lg flex items-center justify-center h-32 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <span class="text-gray-400 text-sm font-medium">Sponsor Logo</span>
                </div>
                <div class="card-modern bg-white p-8 rounded-2xl shadow-lg flex items-center justify-center h-32 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <span class="text-gray-400 text-sm font-medium">Sponsor Logo</span>
                </div>
                <div class="card-modern bg-white p-8 rounded-2xl shadow-lg flex items-center justify-center h-32 hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <span class="text-gray-400 text-sm font-medium">Sponsor Logo</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Share Your Story Section -->
    <section id="share-story" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 animate-fade-in-up">
                <h2 class="text-5xl md:text-6xl font-bold mb-8">
                    <span class="text-gradient">Share Your Story</span>
                </h2>
                <div class="w-32 h-1.5 mx-auto rounded-full mb-8" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(17, 18, 19) 100%);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto font-light">
                    Have an inspiring business journey or leadership story? We'd love to feature your success and vision.
                </p>
            </div>
            
            <div class="max-w-3xl mx-auto">
                <div class="card-modern bg-gradient-to-br from-gray-50 to-white p-12 rounded-3xl shadow-2xl border border-gray-100 relative overflow-hidden">
                    <!-- Decorative elements -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-200 to-blue-200 rounded-full -translate-y-16 translate-x-16 opacity-10"></div>

                    <form id="storyForm" action="{{ route('contact.submit') }}" method="POST" class="space-y-8 relative z-10">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Name</label>
                                <input type="text" name="name" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus-brand transition-all duration-300 bg-white">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Company</label>
                                <input type="text" name="company" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus-brand transition-all duration-300 bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Email</label>
                            <input type="email" name="email" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus-brand transition-all duration-300 bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Tell us your story</label>
                            <textarea rows="6" name="tell_us_your_story" required class="w-full px-6 py-4 border-2 border-gray-200 rounded-2xl focus-brand transition-all duration-300 bg-white resize-none"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="storySubmitBtn" class="btn-modern text-white px-12 py-4 rounded-full text-xl font-bold hover:scale-105 hover:shadow-2xl transition-all duration-300 shadow-xl" style="background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(21, 22, 22) 100%);">
                                Submit Your Story
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-24 bg-gradient-to-br from-gray-50 to-blue-50 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20 animate-fade-in-up">
                <h2 class="text-5xl md:text-6xl font-bold mb-8">
                    <span class="text-gradient">Frequently Asked Questions</span>
                </h2>
                <div class="w-32 h-1.5 mx-auto rounded-full mb-8" style="background: linear-gradient(135deg, #253439 0%, #3a5158 100%);"></div>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto font-light">
                    Get answers to common questions about our publications and how to get featured.
                </p>
            </div>
            
            <div class="max-w-4xl mx-auto">
                <div class="space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="card-modern bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-300 group" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-gradient transition-all duration-300">
                                    What types of business stories do you feature?
                                </h3>
                                <svg class="w-6 h-6 transform transition-transform duration-300 text-gray-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-8 pb-6 text-gray-600 leading-relaxed">
                                We feature inspiring stories of innovation, leadership, and business excellence across all sectors in the GCC region. From emerging startups to established enterprises, we highlight the journeys, challenges overcome, and visions that drive regional progress.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="card-modern bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-300 group" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-gradient transition-all duration-300">
                                    How can I submit my business story?
                                </h3>
                                <svg class="w-6 h-6 transform transition-transform duration-300 text-gray-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-8 pb-6 text-gray-600 leading-relaxed">
                                You can submit your story through our "Share Your Story" form on this page, or contact us directly via email. We'll review your submission and reach out to discuss potential feature opportunities that align with our editorial vision.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="card-modern bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-300 group" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-gradient transition-all duration-300">
                                    What is the publication process timeline?
                                </h3>
                                <svg class="w-6 h-6 transform transition-transform duration-300 text-gray-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-8 pb-6 text-gray-600 leading-relaxed">
                                Our editorial process typically takes 4-6 weeks from initial submission to publication. This includes story review, interview scheduling, content creation, editorial review, and final publication preparation.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="card-modern bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-300 group" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-gradient transition-all duration-300">
                                    Do you charge for featuring businesses?
                                </h3>
                                <svg class="w-6 h-6 transform transition-transform duration-300 text-gray-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-8 pb-6 text-gray-600 leading-relaxed">
                                Our editorial features are merit-based and focus on genuine business excellence and innovation. For specific partnership and sponsorship opportunities, please contact us directly to discuss available options.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 5 -->
                    <div class="card-modern bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <button class="w-full px-8 py-6 text-left focus:outline-none focus:ring-2 focus:ring-purple-400 transition-all duration-300 group" onclick="toggleFaq(this)">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-gradient transition-all duration-300">
                                    Can I nominate another business for featuring?
                                </h3>
                                <svg class="w-6 h-6 transform transition-transform duration-300 text-gray-500 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-8 pb-6 text-gray-600 leading-relaxed">
                                Absolutely! We welcome nominations of inspiring businesses and leaders that you believe deserve recognition. Please provide details about their story and why you think they would be a great fit for our publication.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    @include('partials.footer')

    @include('partials.navigation-scripts')
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // FAQ Toggle Functionality
        function toggleFaq(button) {
            const faqContent = button.nextElementSibling;
            const icon = button.querySelector('svg');
            const isOpen = faqContent.style.maxHeight && faqContent.style.maxHeight !== '0px';
            
            // Close all other FAQ items
            document.querySelectorAll('.faq-content').forEach(content => {
                if (content !== faqContent) {
                    content.style.maxHeight = '0px';
                    content.previousElementSibling.querySelector('svg').style.transform = 'rotate(0deg)';
                }
            });
            
            // Toggle current FAQ item
            if (isOpen) {
                faqContent.style.maxHeight = '0px';
                icon.style.transform = 'rotate(0deg)';
            } else {
                faqContent.style.maxHeight = faqContent.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        
            // Hide all interview sections
            document.querySelectorAll('.country-interviews').forEach(section => {
                section.classList.remove('active');
                section.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.country-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected country interviews
            const targetSection = document.getElementById(country + '-interviews');
            if (targetSection) {
                targetSection.classList.remove('hidden');
                setTimeout(() => {
                    targetSection.classList.add('active');
                }, 10);
            }
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }
    </script>
</body>
</html>