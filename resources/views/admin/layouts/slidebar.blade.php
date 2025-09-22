<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('img/visionLogoWhite.jpg') }}" alt="The Vision" class="img-fluid rounded" style="height: 120px; width: auto;" >
        </a>
    </div>

    <div class="sidebar-content">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Content Management -->
            <li class="nav-section">
                <span class="nav-section-title">Content Management</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                   href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-tags"></i>
                    <span>Categories</span>
                    <span class="badge bg-secondary ms-auto">{{ App\Models\Category::count() }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.interviews.*') ? 'active' : '' }}" 
                   href="{{ route('admin.interviews.index') }}">
                    <i class="fas fa-microphone"></i>
                    <span>Interviews</span>
                    <span class="badge bg-secondary ms-auto">{{ App\Models\Interview::count() }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" 
                   href="{{ route('admin.events.index') }}">
                    <i class="fas fa-calendar"></i>
                    <span>Events</span>
                    <span class="badge bg-secondary ms-auto">{{ App\Models\Event::count() }}</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.podcasts.*') ? 'active' : '' }}" 
                   href="{{ route('admin.podcasts.index') }}">
                    <i class="fas fa-podcast"></i>
                    <span>Podcasts</span>
                    <span class="badge bg-secondary ms-auto">{{ App\Models\Podcast::count() }}</span>
                </a>
            </li>

            <!-- Contact Messages -->
            <li class="nav-section">
                <span class="nav-section-title">Communication</span>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" 
                   href="{{ route('admin.contacts.index') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Contact Messages</span>
                    <span class="badge bg-info ms-auto">{{ App\Models\Contact::count() }}</span>
                </a>
            </li>

         
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-details">
                <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrator</div>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar overlay for mobile -->
<div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>