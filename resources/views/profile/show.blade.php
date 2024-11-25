@extends('layout')
<title>Profile - Shaghlny Platform</title>

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
                ['route' => 'profile.edit', 'icon' => 'user', 'label' => 'Edit Profile'],
                ['route' => 'jobs.create', 'icon' => 'plus-circle', 'label' => 'Post a Job'],
                ['route' => 'jobs.index', 'icon' => 'magnifying-glass', 'label' => 'Find a Job'],
                ['route' => 'jobs.mine', 'icon' => 'briefcase', 'label' => 'My Jobs'],
                ['route' => 'wishlist.index', 'icon' => 'heart', 'label' => 'My Wishlist'],
                ['route' => 'jobs.applied', 'icon' => 'paper-clip', 'label' => 'Applied Jobs']
            ] as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center text-lg text-[#2b6cb0] hover:text-[#1e3a8a] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#e6effc] hover:bg-[#cfdffa]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($item['icon'] === 'home')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 01-2 2h-4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H5a2 2 0 01-2-2V9z" />
                        @elseif($item['icon'] === 'user')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 100-8zM16 16a8 8 0 10-8 8h8a8 8 0 10-8-8z" />
                        @elseif($item['icon'] === 'plus-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        @elseif($item['icon'] === 'magnifying-glass')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l-4-4m4 4l4-4m-4 4l-4-4m4-4l-4 4m-4 0a5 5 0 1010 0 5 5 0 00-10 0z" />
                        @elseif($item['icon'] === 'briefcase')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 6h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2" />
                        @elseif($item['icon'] === 'heart')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-.99a5.5 5.5 0 00-7.78 7.78L12 21.35l8.84-8.84a5.5 5.5 0 000-7.78z" />
                        @elseif($item['icon'] === 'paper-clip')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 9.172a4 4 0 010 5.656l-7 7a4 4 0 01-5.656-5.656l7-7a4 4 0 015.656 0z" />
                        @endif
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Profile Content (Right) -->
    <div class="md:w-3/4 bg-white rounded-lg shadow-lg p-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">My Profile</h2>

        <!-- Information Section -->
        <div class="mb-12">
            <h3 class="text-3xl font-bold text-blue-600 mb-6 border-b-2 border-blue-500 pb-2">
                Personal Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg">
                <p><strong class="text-gray-600">Name:</strong> {{ ucwords(Auth::user()->name) }}</p>
                <p><strong class="text-gray-600">Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong class="text-gray-600">Date of Birth:</strong> {{ $profile->date_of_birth ?? 'Not provided yet' }}</p>
                <p><strong class="text-gray-600">Phone:</strong> {{ $profile->phone ?? 'Not provided yet' }}</p>
            </div>
        </div>

        <!-- Skills Section -->
        <div class="mb-12">
            <h3 class="text-3xl font-bold text-blue-600 mb-6 border-b-2 border-blue-500 pb-2">
                Skills
            </h3>
            <div class="text-lg">
                @if (!empty($profile->skills))
                    <ul class="list-disc ml-8 space-y-2">
                        @foreach ($profile->skills as $skill)
                            <li class="text-gray-800">{{ $skill }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600">No skills added yet.</p>
                @endif
            </div>
        </div>

        <!-- Edit Profile Button -->
        <div class="text-center">
            <a href="{{ route('profile.edit') }}" 
               class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection
