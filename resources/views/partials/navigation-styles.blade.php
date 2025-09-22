<!-- Navigation Styles -->
<style>
    /* Font family for headings */
    h1, h2, h3, h4, h5, h6, .hero-title {
        font-family: 'Raleway', sans-serif;
    }
    
    body {
        font-family: 'Raleway', sans-serif;
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        min-height: 100vh;
    }

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
    
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Glass morphism effect */
    .glass {
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        background-color: rgba(0, 0, 0, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.125);
    }
    
    /* Modern gradient backgrounds */
    .gradient-bg {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
    }
    
    .gradient-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Navigation gradient hover effect */
    .nav-gradient-hover {
        cursor: pointer;
        z-index: 1000;
        position: relative;
    }
    
    .nav-gradient-hover:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        padding: 8px 16px;
        border-radius: 25px;
    }
    
    /* Button styles */
    .btn-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
        color: #000;
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        background: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    /* Mobile Navigation */
    .mobile-menu {
        position: fixed;
        top: -100%;
        left: 0;
        right: 0;
        width: 100%;
        height: 100vh;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.98) 0%, rgba(26, 26, 26, 0.98) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: -1;
        transition: top 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease, z-index 0s ease 0.4s;
        opacity: 0;
        overflow: hidden;
        box-sizing: border-box;
        pointer-events: none;
    }
    
    .mobile-menu.active {
        top: 0;
        opacity: 1;
        z-index: 1000;
        transition: top 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s ease;
        pointer-events: auto;
    }
    
    /* Mobile menu content container */
    .mobile-menu > div {
        max-width: 100%;
        width: 100%;
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        height: 100%;
        box-sizing: border-box;
    }
    
    .mobile-menu a {
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        padding: 16px 32px;
        border-radius: 12px;
        margin: 4px 0;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        width: auto;
        min-width: 200px;
        text-align: center;
        white-space: nowrap;
    }
    
    .mobile-menu a::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        transition: left 0.3s ease;
        z-index: -1;
    }
    
    .mobile-menu a:hover::before {
        left: 0;
    }
    
    .mobile-menu a:hover {
        color: #ffffff;
        transform: translateY(-2px);
    }
    
    /* Mobile menu button animation */
    .mobile-menu-button svg {
        transition: all 0.3s ease;
    }
    
    .mobile-menu-button:hover svg {
        transform: scale(1.1);
    }
    
    /* Prevent body scroll when mobile menu is open */
    body.mobile-menu-open {
        overflow: hidden;
    }
</style>