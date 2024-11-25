@extends('layout')
<title>Login - Shaghlny Platform</title>

@section('content')
    <!-- Main Content Container (added min-height to push content) -->
    <div class="flex flex-col items-center w-full max-w-2xl p-6 space-y-3 bg-white bg-opacity-80 rounded-2xl shadow-xl mt-16 z-10 relative mb-12"> <!-- Added mb-12 for spacing -->
        
        <!-- Login Logo (still circular and animated) -->
        <img src="{{ asset('images/login.jpg') }}" alt="Login Logo" class="w-64 h-64 rounded-full border-4 border-white shadow-2xl mb-4 animate-pulse transition-all duration-500 ease-in-out">

        <!-- Heading -->
        <h2 class="text-3xl font-semibold text-center text-[#333]">Login to Shaghlny</h2>
        <p class="text-center text-black-900 text-lg">Please Login to your account</p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('authenticate') }}" class="w-full space-y-6">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autofocus
                    placeholder="Enter your email"
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#4A628A] focus:border-[#4A628A] transition-all duration-300"
                >
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    placeholder="Enter your password"
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#4A628A] focus:border-[#4A628A] transition-all duration-300"
                >
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center text-gray-600">
                    <input type="checkbox" name="remember" class="w-5 h-5 text-[#C7253E] border-gray-300 rounded-full focus:ring-[#4A628A]">
                    <span class="ml-2 text-sm">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[#C7253E] hover:text-[#A61F31] transition duration-300">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full px-6 py-3 text-white bg-[#37AFE1] rounded-xl shadow-md hover:bg-[#4A628A] focus:outline-none focus:ring-2 focus:ring-[#4A628A] transition-all duration-300">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection
