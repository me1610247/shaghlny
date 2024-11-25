<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom animation for the logo */
        @keyframes pulse-animation {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Background animation for the page */
        @keyframes fadeInAnimation {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Background for body */
        body {
            background: url('https://source.unsplash.com/1600x900/?technology,office,workspace') no-repeat center center fixed;
            background-size: cover;
            background-color: #F9FAFB;
            animation: fadeInAnimation 1.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-[#FAFAFA] flex flex-col items-center justify-between min-h-screen font-sans">

    <!-- Navbar -->
    <nav class="w-full bg-[#37AFE1] py-4 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <!-- Logo with transition and border effect -->
                <img src="{{ asset('images/logo.jpg') }}" alt="Shaghlny Platform Logo" class="w-16 h-16 rounded-full border-4 border-white transition-all duration-300 ease-in-out transform hover:scale-105">
                <div class="text-white text-2xl font-semibold tracking-wide">
                    Shaghlny Platform
                    @if (Auth::check())
                        <p class="text-lg font-semibold text-[#FAFAFA] mt-2">Welcome, {{ ucwords(Auth::user()->name) }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center space-x-4">
                @if (!Auth::check())
                    <a href="/" class="text-white text-lg font-medium hover:text-[#FFF] hover:scale-105 transition-all duration-300 px-4 py-2 rounded-md transform">Home</a>
                    <a href="{{ route('login') }}" class="text-white text-lg font-medium hover:text-[#FFF] hover:scale-105 transition-all duration-300 px-4 py-2 rounded-md transform">Login</a>
                    <a href="{{ route('register') }}" class="text-white text-lg font-medium hover:text-[#FFF] hover:scale-105 transition-all duration-300 px-4 py-2 rounded-md transform">Register</a>
                @else
                    <a href="/" class="text-white text-lg font-medium hover:text-[#FFF] hover:scale-105 transition-all duration-300 px-4 py-2 rounded-md transform">Home</a>
                    <a href="{{ route('profile.show') }}" class="text-white text-lg font-medium hover:text-[#FFF] hover:scale-105 transition-all duration-300 px-4 py-2 rounded-md transform">Profile</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-[#c53030] hover:text-[#822727] transition-all duration-300 font-medium py-2 px-3 rounded-md bg-[#fed7d7] hover:bg-[#feb2b2] shadow-lg hover:shadow-2xl transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" /> <!-- Logout icon -->
                            </svg>
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </nav>
    
    

    
    <!-- Main Content Section -->
    @yield('content')

    <script>
        // Toggle Mobile Menu
        document.getElementById("hamburger").addEventListener("click", function() {
            var menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
        });
    </script>

</body>
</html>
