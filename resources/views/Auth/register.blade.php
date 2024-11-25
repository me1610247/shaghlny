@extends('layout')
<title>Register - Shaghlny Platform</title>
@section('content')
        <!-- Register Form Container -->
    <div class="flex flex-col items-center w-full max-w-2xl p-6 space-y-3 bg-white bg-opacity-80 rounded-2xl shadow-xl mt-16 z-10 relative">
        <!-- Register Logo (increased size to w-64 h-64) -->
        <img src="{{ asset('images/register.jpg') }}" alt="Register Logo" class="w-64 h-64 rounded-full border-4 border-white shadow-2xl mb-4 animate-pulse transition-all duration-500 ease-in-out">

        <!-- Heading -->
        <h2 class="text-3xl font-semibold text-center text-[#333]">Register to Shaghlny</h2>
        <p class="text-center text-black-900 text-lg">Please create your account</p>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="w-full space-y-4">
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
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    required
                    autofocus
                    placeholder="Enter your full name"
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#C7253E] focus:border-[#C7253E] transition-all duration-300"
                >
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    placeholder="Enter your email"
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#C7253E] focus:border-[#C7253E] transition-all duration-300"
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
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#C7253E] focus:border-[#C7253E] transition-all duration-300"
                >
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    placeholder="Confirm your password"
                    class="w-full mt-2 p-4 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-[#C7253E] focus:border-[#C7253E] transition-all duration-300"
                >
            </div>

            <!-- Submit Button -->
             <!-- Submit Button -->
             <div>
                <button type="submit" class="w-full px-6 py-3 text-white bg-[#37AFE1] rounded-xl shadow-md hover:bg-[#A61F31] focus:outline-none focus:ring-2 focus:ring-[#C7253E] transition-all duration-300">
                    Register
                </button>
            </div>
        </form>
    </div>
@endsection