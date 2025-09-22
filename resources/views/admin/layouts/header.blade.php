<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Sidebar Toggle -->
        <button class="btn btn-link d-md-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <span class="fw-bold">Admin Panel</span>
        </a>

        <!-- Right Side -->
        <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
            <!-- Quick Actions -->
            <div class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" id="quickActionsDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-plus"></i> Quick Add
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.categories.create') }}">
                        <i class="fas fa-tags me-2"></i>New Category
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.interviews.create') }}">
                        <i class="fas fa-microphone me-2"></i>New Interview
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.events.create') }}">
                        <i class="fas fa-calendar me-2"></i>New Event
                    </a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.podcasts.create') }}">
                        <i class="fas fa-podcast me-2"></i>New Podcast
                    </a></li>
                </ul>
            </div>

         
            

            <!-- User Menu -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                 
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>