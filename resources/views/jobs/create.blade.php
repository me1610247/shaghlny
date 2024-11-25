@extends('layout')
<title>Add Job - Shaghlny Platform</title>
@section('content')
    <div class="container mx-auto py-16 px-4 md:flex md:space-x-10">
        
        <!-- Sidebar (Left) -->
        <div class="md:w-1/4 bg-gradient-to-b from-[#f0f4f8] to-[#d9e2ec] p-8 rounded-xl shadow-xl space-y-8">
            <h2 class="text-2xl font-bold text-center text-[#1a202c] mb-6 border-b-4 border-[#2b6cb0] pb-2">
                Dashboard
            </h2>
        
            <div class="flex flex-col space-y-4">
                @foreach([
                    ['route' => 'home', 'icon' => 'home', 'label' => 'Home'],
                    ['route' => 'jobs.create', 'icon' => 'plus-circle', 'label' => 'Post a Job'],
                    ['route' => 'jobs.index', 'icon' => 'magnifying-glass', 'label' => 'Find a Job'],
                    ['route' => 'jobs.mine', 'icon' => 'briefcase', 'label' => 'My Jobs'],
                    ['route' => 'wishlist.index', 'icon' => 'heart', 'label' => 'My Wishlist'],
                    ['route' => 'jobs.applied', 'icon' => 'paper-clip', 'label' => 'Applied Jobs']
                ] as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center text-lg text-[#2b6cb0] hover:text-[#1e3a8a] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#e6effc] hover:bg-[#cfdffa]">
                        <!-- Use Heroicons here for icons -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <!-- Home Icon -->
                            @if($item['icon'] == 'home')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 01-2 2h-4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H5a2 2 0 01-2-2V9z" />
                            @elseif($item['icon'] == 'plus-circle')
                                <!-- Post a Job Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            @elseif($item['icon'] == 'magnifying-glass')
                                <!-- Find a Job Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l-4-4m4 4l4-4m-4 4l-4-4m4-4l-4 4m-4 0a5 5 0 1010 0 5 5 0 00-10 0z" />
                            @elseif($item['icon'] == 'briefcase')
                                <!-- My Jobs Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 6h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2" />
                            @elseif($item['icon'] == 'heart')
                                <!-- My Wishlist Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-.99a5.5 5.5 0 00-7.78 7.78L12 21.35l8.84-8.84a5.5 5.5 0 000-7.78z" />
                            @elseif($item['icon'] == 'paper-clip')
                                <!-- Applied Jobs Icon -->
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 9.172a4 4 0 010 5.656l-7 7a4 4 0 01-5.656-5.656l7-7a4 4 0 015.656 0z" />
                            @endif
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
        
                <a href="#" class="flex items-center text-lg text-[#c53030] hover:text-[#822727] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#fed7d7] hover:bg-[#feb2b2]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
        

        <!-- Main Content (Right) -->
        <div class="md:w-3/4 space-y-6">
            <a href="{{ route('jobs.create.as.company') }}" 
   class="flex items-center text-lg text-[#2b6cb0] hover:text-[#1e3a8a] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#e6effc] hover:bg-[#cfdffa]">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Post Job as a Company
</a>
            <!-- Hero Section (Heading & Intro) -->
            <div class="text-center space-y-4">
                <h2 class="text-4xl font-bold text-[#333] mb-8 border-b-4 border-blue-500 pb-3 text-center">
                    Post a Job
                </h2>            
                <p class="text-xl text-gray-600">Fill in the details below to post a new job opening.</p>
            </div>

            <!-- Form Section -->
            <div class="bg-white p-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
                <form action="{{ route('jobs.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Job Title -->
                    <div class="mb-8">
                        <label for="title" class="block text-gray-800 font-semibold text-lg">Job Title</label>
                        <input type="text" name="title" id="title" 
                               class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                               value="{{ old('title') }}" required>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-8">
                        <label for="description" class="block text-gray-800 font-semibold text-lg">Job Description</label>
                        <textarea name="description" id="description" 
                                  class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" 
                                  rows="6" required>{{ old('description') }}</textarea>
                    </div>

                    <!-- Location -->
                    <div class="mb-8">
                        <label for="location" class="block text-gray-800 font-semibold text-lg">Location (Optional)</label>
                        <input type="text" name="location" id="location" 
                               class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                               value="{{ old('location') }}">
                    </div>

                    <!-- Job Type -->
                    <div class="mb-8">
                        <label for="job_type" class="block text-gray-800 font-semibold text-lg">Job Type</label>
                        <select name="job_type" id="job_type" 
                                class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" required>
                            <option value="Full-time" {{ old('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Part-time" {{ old('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                            <option value="Contract" {{ old('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Freelancer" {{ old('job_type') == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                        </select>
                    </div>

                    <!-- Salary -->
                    <div class="mb-8">
                        <label for="salary" class="block text-gray-800 font-semibold text-lg">Salary (Optional)</label>
                        <input type="number" name="salary" id="salary" 
                               class="w-full mt-2 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                               value="{{ old('salary') }}">
                    </div>

                    <button type="submit" class="w-full bg-[#37AFE1] text-white text-lg font-semibold py-4 rounded-lg shadow-md hover:bg-[#4A628A] transition duration-300 ease-in-out">
                        Post Job
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
