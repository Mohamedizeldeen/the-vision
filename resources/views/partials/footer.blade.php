<!-- Advanced Footer -->
<footer class="bg-black text-white pt-12 pb-6 relative px-4 sm:px-8 md:px-16">
    <div class="container mx-auto px-2 sm:px-4 md:px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left">
            <!-- About -->
            <div>
                <img src="{{ asset('img/visionLogoWhite.jpg') }}" alt="The Vision Logo" class="mx-auto md:mx-0 mb-4 h-12" style="width: 100px; height: auto;">
                <p class="text-gray-400 text-base">Showcasing the inspiring journeys of GCC business leaders.</p>
            </div>
            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('events.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:underline">Events</a></li>
                    <li><a href="{{ route('interviews.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:underline">Interviews</a></li>
                    <li><a href="{{ route('podcasts.index') }}" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:underline">Podcasts</a></li>
                    @auth
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:underline">Admin</a></li>
                    @endauth
                </ul>
            </div>
            <!-- Contact -->
            <div>
                <h4 class="text-lg font-semibold mb-3">Contact</h4>
                <ul class="space-y-2 text-gray-400 text-base">
                    <li><i class="fas fa-envelope mr-2"></i><a href="mailto:info@thevision-media.com" class="hover:text-white focus:underline">info@thevision-media.com</a></li>
                    <li><i class="fas fa-phone mr-2"></i><a href="tel:+9687751766" class="hover:text-white focus:underline">+968 775 1766</a></li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i>Muscat, Oman</li>
                </ul>
            </div>
            <!-- Social -->
            <div>
                <h4 class="text-lg font-semibold mb-3">Follow Us</h4>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="https://www.linkedin.com/company/thevisionmedia/?viewAsMember=true" target="_blank" aria-label="LinkedIn" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-white rounded">
                        <i class="fab fa-linkedin fa-2x"></i>
                    </a>
                    <a href="https://www.instagram.com/thevision.media.official_?igsh=MTZmcnRsNTNpbGVsNg%3D%3D&utm_source=qr" target="_blank" aria-label="Instagram" class="text-gray-400 hover:text-white transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-white rounded">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <!-- Add more social links as needed -->
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-4 text-center text-gray-500 text-sm">
            © {{ date('Y') }} The Vision. All rights reserved.
        </div>
    </div>
</footer>