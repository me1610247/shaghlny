@extends('layout')
<title>Company - Shaghlny Platform</title>
@section('content')
<div class="container mx-auto py-16 px-4 md:flex md:space-x-12">
    <!-- Sidebar (Left) -->
    <div class="md:w-1/4 bg-gradient-to-b from-[#f0f4f8] to-[#d9e2ec] p-8 rounded-xl shadow-xl space-y-8">
        <h2 class="text-2xl font-bold text-center text-[#1a202c] mb-6 border-b-4 border-[#2b6cb0] pb-2">
            Dashboard
        </h2>

        <!-- Sidebar links -->
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
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($item['icon'] == 'home')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 01-2 2h-4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H5a2 2 0 01-2-2V9z" />
                        @elseif($item['icon'] == 'plus-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        @elseif($item['icon'] == 'magnifying-glass')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l-4-4m4 4l4-4m-4 4l-4-4m4-4l-4 4m-4 0a5 5 0 1010 0 5 5 0 00-10 0z" />
                        @elseif($item['icon'] == 'briefcase')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 6h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h2" />
                        @elseif($item['icon'] == 'heart')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-.99a5.5 5.5 0 00-7.78 7.78L12 21.35l8.84-8.84a5.5 5.5 0 000-7.78z" />
                        @elseif($item['icon'] == 'paper-clip')
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
    <div class="md:w-3/4 space-y-8">
        <div class="text-center space-y-4">
            <h5 class="text-3xl font-semibold text-[#2b2b2b] mb-6 border-b-2 border-[#4A90E2] pb-2">
                Companies with Job Listings
            </h5>

            @if ($jobsWithQuestions->isEmpty())
                <p class="text-lg text-gray-500">No companies with job listings available at the moment.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobsWithQuestions as $job)
                        <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 flex flex-col h-full">
                            <div class="flex-grow">
                                <div class="text-center">
                                    @if($job->image)
                                        <img src="{{ asset('storage/' . $job->image) }}" alt="Job Image" class="w-full h-48 object-cover mb-4">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                    <h3 class="text-2xl font-semibold text-[#333] mb-2">{{ $job->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($job->description, 150) }}</p>
                                    <!-- Display Questions -->
                                    <p class="text-sm text-gray-500 mb-4">Questions for this job:</p>
                                    <ul class="list-disc pl-5 text-left text-sm text-gray-600 mb-4">
                                        @foreach($job->questions as $question)
                                            <li>{{ $question->question }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <form action="{{ route('jobs.apply', $job->id) }}" method="POST" class="inline-block">
                                @csrf <!-- Protects the form from CSRF attacks -->
                                <button type="submit" 
                                        class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">
                                    Apply
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
