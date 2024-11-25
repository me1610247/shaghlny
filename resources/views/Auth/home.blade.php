@extends('layout')
<title>Home - Shaghlny Platform</title>

@section('content')
    <!-- Main Container -->
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
        <div class="md:w-3/4 space-y-6">
            <!-- Hero Section (Heading & Intro) -->
            <div class="text-center space-y-6 py-16 px-4 bg-gradient-to-r from-[#2C3E50] to-[#34495E] rounded-lg shadow-xl">
                <h1 class="text-5xl font-extrabold text-white tracking-wide leading-tight">
                    Welcome to Shaghlny Platform
                </h1>
                <p class="text-2xl text-gray-200 mt-4">
                    Connect with top talent or post job opportunities to grow your business.
                </p>              
            </div>
            <div class="container mx-auto my-10">
                <h2 class="text-xl font-bold mb-4">Job Statistics</h2>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                    <!-- Jobs by Month Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">Jobs Created by Month</h3>
                        <canvas id="jobsByMonthChart"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">Jobs by Title</h3>
                        <canvas id="jobTitleChart"></canvas>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">Jobs by Type</h3>
                        <canvas id="jobTypeChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Action Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Find a Job Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <img src="{{ asset('images/find-job.jpg') }}" alt="Find Job" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-2xl font-semibold text-[#333] mb-2">Find a Job</h3>
                        <p class="text-gray-600 mb-4">Explore available job listings based on your skills and preferences.</p>
                        <a href="{{route('jobs.index')}}" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">Browse Jobs</a>
                    </div>
                </div>

                <!-- Post a Job Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <img src="{{ asset('images/hiring.jpg') }}" alt="Post Job" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-2xl font-semibold text-[#333] mb-2">Post a Job</h3>
                        <p class="text-gray-600 mb-4">Looking for candidates? Post job opportunities and attract the best talent.</p>
                        <a href="{{route('jobs.create')}}" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#388E3C] transition duration-300">Post a Job</a>
                    </div>
                </div>

                <!-- My Jobs Card -->
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="text-center">
                        <img src="{{ asset('images/company.jpg') }}" alt="Companies" class="w-full h-48 object-cover rounded-lg mb-4">
                        <h3 class="text-2xl font-semibold text-[#333] mb-2">For Companies</h3>
                        <p class="text-gray-600 mb-4">Companies can create profiles to manage their job listings and attract the right talent.</p>
                        <a href="{{route('companies.index')}}" class="text-white bg-[#37AFE1] py-2 px-6 rounded-full hover:bg-[#4A628A] transition duration-300">Explore</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data for job types
        const jobTypeLabels = @json($jobTypeData->pluck('job_type'));
        const jobTypeCounts = @json($jobTypeData->pluck('count'));

        // Data for jobs by month (already processed in the controller)
        const months = @json($months);
        const jobCounts = @json($jobsByMonth->pluck('count'));

        // Jobs by Type Chart
        const jobTypeCtx = document.getElementById('jobTypeChart').getContext('2d');
        new Chart(jobTypeCtx, {
            type: 'pie',
            data: {
                labels: jobTypeLabels,
                datasets: [{
                    label: 'Jobs by Type',
                    data: jobTypeCounts,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    hoverOffset: 4
                }]
            }
        });

        // Jobs by Month Chart
        const jobsByMonthCtx = document.getElementById('jobsByMonthChart').getContext('2d');
        new Chart(jobsByMonthCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Jobs Created',
                    data: jobCounts,
                    backgroundColor: '#4A90E2'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        const jobTitleLabels = @json($jobTitleData->pluck('title'));
        const jobTitleCounts = @json($jobTitleData->pluck('count'));

        // Job Titles Bar Chart
        const jobTitleCtx = document.getElementById('jobTitleChart').getContext('2d');
        new Chart(jobTitleCtx, {
            type: 'bar',
            data: {
                labels: jobTitleLabels,
                datasets: [{
                    label: 'Jobs by Title',
                    data: jobTitleCounts,
                    backgroundColor: '#4A90E2', // Bar color
                    borderColor: '#2c3e50',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: true // Hide legend if not needed
                    }
                }
            }
        });
    </script>
@endsection
