<!-- Navigation Scripts -->
<script>
    // Mobile menu toggle
    function toggleMobileMenu() {
        console.log('toggleMobileMenu called'); // Debug log
        const mobileMenu = document.querySelector('.mobile-menu');
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        const closeIcon = document.querySelector('.close-icon');
        const body = document.body;
        
        console.log('Mobile menu element:', mobileMenu); // Debug log
        
        if (mobileMenu.classList.contains('active')) {
            mobileMenu.classList.remove('active');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            body.style.overflow = '';
        } else {
            mobileMenu.classList.add('active');
            hamburgerIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            body.style.overflow = 'hidden';
        }
    }
    
    function closeMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        const closeIcon = document.querySelector('.close-icon');
        const body = document.body;
        
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
        }
        if (hamburgerIcon) {
            hamburgerIcon.classList.remove('hidden');
        }
        if (closeIcon) {
            closeIcon.classList.add('hidden');
        }
        body.style.overflow = '';
        console.log('Mobile menu closed'); // Debug log
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        
        if (mobileMenu && mobileMenuButton && 
            mobileMenu.classList.contains('active') && 
            !mobileMenu.contains(event.target) && 
            !mobileMenuButton.contains(event.target)) {
            closeMobileMenu();
        }
    });
    
    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 768) { // md breakpoint
            closeMobileMenu();
        }
    });
    
    // Alternative event listener for mobile menu button (in case onclick doesn't work)
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure mobile menu is closed on page load
        closeMobileMenu();
        
        const mobileMenuButton = document.querySelector('#mobile-menu-btn') || document.querySelector('.mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function(e) {
                console.log('Mobile menu button clicked via event listener'); // Debug log
                e.preventDefault();
                toggleMobileMenu();
            });
        }
        
        // Make functions globally accessible
        window.toggleMobileMenu = toggleMobileMenu;
        window.closeMobileMenu = closeMobileMenu;
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add scroll effect to header
    window.addEventListener('scroll', function() {
        const header = document.querySelector('header');
        if (header) {
            if (window.scrollY > 100) {
                header.style.backgroundColor = 'rgba(0, 0, 0, 0.95)';
            } else {
                header.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            }
        }
    });
    
    // Intersection Observer for animations
    document.addEventListener('DOMContentLoaded', function() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);
        
        // Observe elements for animation
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    });
</script>