<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Music Fiesta Hub</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="top-bar">
    <div class="logo">
        <!-- Logo Section -->
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Ceylon Trails Logo" class="h-12">
        </a>
    </div>
    <div class="menu">
        <a href="{{ route('home') }}">Events</a>
        <a href="{{ route('music') }}">Music</a>
        <a href="{{ route('happenings') }}">News</a>
        <a href="{{route('information')}}">About Us</a>
    </div>
    <div class="actions">
        @auth
            <!-- Show user's name and placeholder profile picture -->
            <div class="relative group">
                <button class="flex items-center space-x-2 focus:outline-none">
                    <div class="w-8 h-8 bg-gray-300 rounded-full overflow-hidden">
                        <img src="{{ asset('images/placeholder_profile_pic.jpg') }}" alt="Profile Picture" class="w-full h-full object-cover">
                    </div>
                    <span class="text-white font-semibold">{{ Auth::user()->username }}</span>
                </button>

                <!-- Dropdown Menu -->
                <ul class="absolute right-0 mt-0 w-48 bg-white border rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-1500 z-10 pointer-events-none group-hover:pointer-events-auto" style="color: #9ca3af">
                    <li><a href="{{ route('profile.profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a></li>

                </ul>
            </div>

        @else
            <!-- Show Sign In button if user is not authenticated -->
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white border border-gray-300 rounded hover:bg-gray-100" style="color: #9ca3af">Sign In</a>
        @endauth
    </div>
</div>

<!-- Main Content -->
<main>
    @yield('content')
</main>

<div class="bottom-links">
    <div class="related-sites">
        <p>Related Sites</p>
        <ul>
            <li><a href="#">Music For Me</a></li>
            <li><a href="#">Hot News</a></li>
            <li><a href="#">Up Coming Events</a></li>

        </ul>
    </div>
    <div class="connect">
        <p>Connect With Us</p>
        <ul>
            <li><a href="#"><img src="{{ asset('images/youtube-icon.png') }}" alt="YouTube"></a></li>
            <li><a href="#"><img src="{{ asset('images/facebook-icon.png') }}" alt="Facebook"></a></li>
            <li><a href="#"><img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter"></a></li>
            <li><a href="#"><img src="{{ asset('images/instagram-icon.png') }}" alt="Instagram"></a></li>
            <li><a href="#"><img src="{{ asset('images/pinterest-icon.png') }}" alt="Pinterest"></a></li>
        </ul>
    </div>
    <div class="legal">
        <p><a href="#">Terms of Use</a></p>
        <p><a href="#">Privacy</a></p>
        <p><a href="#">Cookie Policy</a></p>
        <p><a href="#">Report Site Issues</a></p>
    </div>
</div>
@stack('scripts')
</body>
</html>
