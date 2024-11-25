<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Shaghlny Platform</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Background animation for the page */
        body {
            background: url('https://source.unsplash.com/1600x900/?technology,office,workspace') no-repeat center center fixed;
            background-size: cover;
            background-color: #F9FAFB;
        }

        /* Fade in effect for sections */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 1.5s ease-out forwards;
        }

        .hover-transition:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-[#F9FAFB] font-sans">

    <!-- Navbar -->
    <nav class="w-full bg-[#37AFE1] py-5 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('images/logo.jpg') }}" alt="Shaghlny Platform Logo" class="w-16 h-16 rounded-full border-4 border-white transition-all duration-500 ease-in-out">
                <div class="text-white text-2xl font-semibold">Shaghlny Platform</div>
            </div>
            <div class="space-x-6">
                @if (!Auth::check())
                <a href="/" class="text-white text-lg hover:text-[#FFF] transition duration-300">Home</a>
                <a href="{{ route('login') }}" class="text-white text-lg hover:text-[#FFF] transition duration-300">Login</a>
                <a href="{{ route('register') }}" class="text-white text-lg hover:text-[#FFF] transition duration-300">Register</a>
                @else                
                <a href="#"
                   class="flex items-center text-lg text-[#c53030] hover:text-[#822727] transition-all duration-300 font-medium py-3 px-4 rounded-md bg-[#fed7d7] hover:bg-[#feb2b2] shadow-lg hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" /> <!-- Logout icon -->
                    </svg>
                    Logout
                </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Hero Section (Logo and Introduction) -->
    <section class="flex flex-col items-center justify-center bg-[#37AFE1] py-2 text-white text-center space-y-6">
        <img src="{{ asset('images/logo.jpg') }}" alt="Shaghlny Logo" class="w-64 h-64 rounded-full border-4 border-white shadow-xl mb-4">
        <h1 class="text-5xl font-extrabold leading-tight text-shadow-md">Welcome to Shaghlny</h1>
        <p class="text-xl font-medium max-w-2xl mx-auto">Your all-in-one platform for seamless job hunting, talent acquisition, and career growth.</p>
        @if (!Auth::check())
        <a href="{{ route('login') }}" class="mt-6 px-8 py-4 bg-white text-[#37AFE1] rounded-full text-xl font-semibold hover:bg-[#E0F2F7] transition-all duration-300">Get Started</a>
        @else
        <a href="{{ route('home') }}" class="mt-6 px-8 py-4 bg-white text-[#37AFE1] rounded-full text-xl font-semibold hover:bg-[#E0F2F7] transition-all duration-300">Get Started</a>
        @endif
    </section>

    <!-- About Us Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 text-center fade-in">
        <h2 class="text-4xl font-bold text-[#333] mb-6">What is Shaghlny?</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">Shaghlny is a platform designed to connect job seekers with companies looking for talent. Whether you're looking to advance your career or find the perfect candidate, Shaghlny offers tools that make the job search process more efficient, transparent, and accessible.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-4 flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover-transition">
                <img src="{{ asset('images/job-search.jpg') }}" alt="Job Search" class="rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Job Search</h3>
                <p class="text-gray-600">Find the best opportunities based on your skills and experience.</p>
            </div>
            <div class="space-y-4 flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover-transition">
                <img src="{{asset('images/recruitment.jpg')}}" alt="Recruitment" class="rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Recruitment</h3>
                <p class="text-gray-600">Employers can easily find the right candidates for their roles.</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-[#F9FAFB] py-20 text-center fade-in">
        <h2 class="text-4xl font-bold text-[#333] mb-6">Our Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="space-y-4 flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover-transition">
                <img src="{{asset('images/success.jpg')}}" alt="Team Success" class="object-cover rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Success & Growth</h3>
                <p class="text-gray-600 leading-relaxed">"Shaghlny connected you with the right talent, enabling our team to grow and innovate."</p>
            </div>
            <div class="space-y-4 flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover-transition">
                <img src="{{asset('images/technology.jpg')}}" alt="Technology" class="object-cover rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Technology Integration</h3>
                <p class="text-gray-600">We use the latest technology to offer the best experience for users.</p>
            </div>
            <div class="space-y-4 flex flex-col items-center p-6 bg-white rounded-lg shadow-md hover-transition">
                <img src="{{asset('images/career.jpg')}}" alt="Career Development" class="object-cover rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold">Career Development</h3>
                <p class="text-gray-600">Get personalized recommendations to help you advance in your career.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 text-center fade-in">
        <h2 class="text-4xl font-bold text-[#333] mb-6">Contact Us</h2>
        <p class="text-lg text-gray-600 mb-6">Have questions or need assistance? Get in touch with us!</p>
        <a href="mailto:contact@shaghlny.com" class="px-8 py-4 bg-[#37AFE1] text-white rounded-full text-xl font-semibold hover:bg-[#1D8CBA] transition-all duration-300">Contact Us</a>
    </section>

    <!-- Footer -->
    <footer class="bg-[#37AFE1] py-6 text-center text-white">
        <p>&copy; 2024 Shaghlny Platform. All rights reserved.</p>
    </footer>

</body>
</html>
