<!-- Main navbar -->
<style>
    .navbar {
        padding-top: -20px;
        margin-bottom:-20px;
        background-color: #0505f2;
    }
 
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
 
    .navbar-logo {
        width: 200px;
        height: 500px;
        border: 2px solid #fff;
        border-radius: 8px;
    }
 
    .navbar-brand h4 {
        color: #fff;
        font-weight: 600;
        font-size: 1.4rem;
        margin-right: 900px;
    }
 
    .navbar-brand img {
        width: 70px;
        height: 70px;
        border: 2px solid #fff;
        border-radius: 8px;
    }
 
    .nav-link {
        color: rgba(255, 255, 255, 0.9) !important;
        padding: 0.5rem 1rem;
    }
 
    .nav-link:hover {
        color: #fff !important;
    }
 
    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.5);
        padding: 0.25rem;
    }
 
    .navbar-toggler i {
        color: #fff;
    }
 </style>
 
 <nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img class="navbar-logo" src="{{ asset('global_assets/images/logo.png') }}" alt="Logo">
        <h4>{{ Qs::getSystemName() }}</h4>
    </a>
 
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-mobile">
        <i class="icon-tree5"></i>
    </button>
 
    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="icon-home"></i>
                    <span class="d-md-none ms-2">Home</span>
                </a>
            </li>
 
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">
                    <i class="icon-user-tie"></i>
                    <span class="d-md-none ms-2">My Account</span>
                </a>
            </li>
 
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="icon-cog3"></i>
                    <span class="d-md-none ms-2">Options</span>
                </a>
            </li>
        </ul>
    </div>
 </nav>