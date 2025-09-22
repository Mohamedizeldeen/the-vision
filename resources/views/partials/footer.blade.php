<!-- Footer -->
<footer class="bg-black text-white py-12 relative">
    <div class="container mx-auto px-6">
        <div class="text-center">
            <h3 class="text-3xl font-bold mb-6">
                <span class="text-transparent bg-clip-text" style="background: linear-gradient(135deg,rgb(255, 255, 255) 0%,rgb(255, 255, 255) 100%); -webkit-background-clip: text; background-clip: text;">The Vision</span>
            </h3>
            <p class="text-gray-400 mb-6 text-lg">Showcasing the inspiring journeys of GCC business leaders</p>
            
            <!-- Social Links -->
            <div class="flex justify-center space-x-6 mb-6">
                <a href="https://www.linkedin.com/company/thevisionmedia/?viewAsMember=true" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
                <a href="https://www.instagram.com/thevision.media.official_?igsh=MTZmcnRsNTNpbGVsNg%3D%3D&utm_source=qr" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fab fa-youtube fa-2x"></i>
                </a>
            </div>

            <!-- Quick Links -->
            <div class="flex justify-center space-x-6 mb-6 text-sm">
                <a href="{{ route('events.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Events</a>
                <a href="{{ route('interviews.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Interviews</a>
                <a href="{{ route('podcasts.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Podcasts</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition-colors duration-300">Admin</a>
                @endauth
            </div>

            <!-- Contact Info -->
            <div class="mb-6 text-gray-400 text-sm">
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-6">
                    <span><i class="fas fa-envelope mr-2"></i>info@thevision-media.com</span>
                    <span><i class="fas fa-phone mr-2"></i>+968 775 1766</span>
                    <span><i class="fas fa-map-marker-alt mr-2"></i>Muscat, Oman</span>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-gray-500 text-sm">
                © {{ date('Y') }} The Vision. All rights reserved.
            </div>
        </div>
    </div>
</footer>