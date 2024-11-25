@extends('layout')

<title>Jobs - Shaghlny Platform</title>

@section('content')
<div class="container mx-auto py-16 px-4 md:flex md:space-x-12">
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
    <div class="md:w-3/4 space-y-8">
        <div class="text-center space-y-4">
            @if(session('success'))
            <div class="alert alert-success text-white bg-green-500 p-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger text-white bg-red-500 p-4 rounded-md">
            {{ session('error') }}
        </div>
         @endif
            <!-- Recommended Jobs Section -->
            <h5 class="text-3xl font-semibold text-[#2b2b2b] mb-6 border-b-2 border-[#4A90E2] pb-2">
                Recommended Jobs
            </h5>

            @if (empty($recommendedJobs))
                <p class="text-lg text-gray-500">No recommended jobs at the moment. Please add skills to your profile to get recommendations.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recommendedJobs as $jobRecommended)
                    <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-[#37AFE1]">
                        @if($jobRecommended->questions()->exists())
                        <p class="text-xl font-semibold text-[#333] mb-4">Company: {{ $jobRecommended->name }}</p>
                        <p class="text-xl font-semibold text-[#333] mb-4">Job Title: {{ $jobRecommended->title }}</p>
                        @else
                        <h3 class="text-xl font-semibold text-[#333] mb-4">{{ $jobRecommended->title }}</h3> 
                        @endif                       
                         <p class="text-sm text-gray-600 mb-4">{{ Str::limit($jobRecommended->description, 150) }}</p>
                        <p class="text-sm text-gray-500 mb-2">Location: {{ $jobRecommended->location ?? 'Not specified' }}</p>
                        <p class="text-sm text-gray-500 mb-2">Salary: {{ $jobRecommended->salary ? 'L.E ' . number_format($jobRecommended->salary, 2) : 'Not specified' }}</p>
                        <p class="text-sm text-gray-500 mb-4">Job Type: {{ $jobRecommended->job_type }}</p>
                        <div class="mt-4 flex justify-between space-x-2">
                            <!-- Favourite Button -->
                            <form action="{{ route('wishlist.add', $jobRecommended->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">
                                    Add to Wishlist
                                </button>
                            </form>
                
                            <!-- Apply Button -->
                            @if(auth()->user()->appliedJobs->contains($jobRecommended->id))
                                <button class="text-white bg-gray-500 py-2 px-6 rounded-full cursor-not-allowed">
                                    Applied
                                </button>
                            @else
                                <form action="{{ route('jobs.apply', $jobRecommended->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">
                                        Apply Now
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
                
                </div>
            @endif

            <!-- All Jobs Section -->
            <h5 class="text-3xl font-semibold text-[#2b2b2b] mb-6 border-b-2 border-[#4A90E2] pb-2">
                All Available Jobs
            </h5>

            @if ($jobs->isEmpty())
                <p class="text-center text-gray-500">No jobs available at the moment.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                    <div class="bg-white p-6 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 border-t-4 border-[#37AFE1]">
                        @if($job->questions()->exists())
                        <p class="text-xl font-semibold text-[#333] mb-4">Company: {{ $job->name }}</p>
                        <p class="text-xl font-semibold text-[#333] mb-4">Job Title: {{ $job->title }}</p>
                        @else
                        <h3 class="text-xl font-semibold text-[#333] mb-4">{{ $job->title }}</h3> 
                        @endif
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($job->description, 150) }}</p>
                        <p class="text-sm text-gray-500 mb-2">Location: {{ $job->location ?? 'Not specified' }}</p>
                        <p class="text-sm text-gray-500 mb-2">Salary: {{ $job->salary ? 'L.E ' . number_format($job->salary, 2) : 'Not specified' }}</p>
                        <p class="text-sm text-gray-500 mb-4">Job Type: {{ $job->job_type }}</p>
                        <div class="mt-4 flex justify-between space-x-2">
                            <!-- Favourite Button -->
                            <form action="{{ route('wishlist.add', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">
                                    Add to Wishlist
                                </button>
                            </form>
                
                            <!-- Apply Button -->
                            @if(auth()->user()->appliedJobs->contains($job->id))
                                <button class="text-white bg-gray-500 py-2 px-6 rounded-full cursor-not-allowed">
                                    Applied
                                </button>
                            @else
                                <form action="{{ route('jobs.apply', $job->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">
                                        Apply Now
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                
                </div>

                <!-- Pagination Links -->
                <div class="mt-8">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the job_id from the URL query string
        const urlParams = new URLSearchParams(window.location.search);
        const jobId = urlParams.get('job_id');

        if (jobId) {
            // Find the job element with the matching ID (assuming each job has an ID as its HTML ID)
            const jobElement = document.getElementById('job-' + jobId);
            if (jobElement) {
                // Scroll the page to the job element
                jobElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // Optionally, you can add a highlight effect here
                jobElement.classList.add('bg-yellow-100'); // Adding background color as an example
            }
        }
    });

</script>