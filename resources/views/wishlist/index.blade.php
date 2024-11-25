@extends('layout')
<title>Wishlist - Shaghlny Platform</title>
@section('content')
<div class="container mx-auto py-16 px-4 md:flex md:space-x-10">
    <!-- Sidebar -->
    <div class="md:w-1/4 bg-gradient-to-b from-[#f8fafc] to-[#e7ebf0] p-6 rounded-xl shadow-lg space-y-8">
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
                <a href="{{ route($item['route']) }}" class="flex items-center text-lg text-[#2c5282] hover:text-[#2b6cb0] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#f0f4f8] hover:bg-[#d9e2ec]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

            <a href="#" class="flex items-center text-lg text-[#e53e3e] hover:text-[#c53030] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#fee2e2] hover:bg-[#fed7d7]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4z" />
                </svg>
                Logout
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="md:w-3/4 space-y-6">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-6">My Wishlist</h1>

        @if($wishlistItems->isEmpty())
            <p class="text-gray-500 text-lg">Your wishlist is empty. Start adding some jobs you like!</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($wishlistItems as $item)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-2xl font-semibold text-gray-700">{{ $item->job->title }}</h3>
                        <p class="text-gray-600 mt-2 mb-4">{{ Str::limit($item->job->description, 100) }}</p>
                        <p class="text-gray-500">Location: <span class="font-medium">{{ $item->job->location }}</span></p>

                        <!-- View Button -->
                        <a href="{{ route('jobs.index', ['job_id' => $item->job->id]) }}"
                            class="text-white bg-blue-500 py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300 mt-4 inline-block"
                            data-job-id="{{ $item->job->id }}">
                            View
                        </a>
                        <!-- Remove from Wishlist Button -->
                        <form action="{{ route('wishlist.remove', $item->job->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit"
                            class="flex items-center text-[#e53e3e] hover:text-[#c53030] transition duration-300 font-medium py-3 px-4 rounded-md bg-[#fee2e2] hover:bg-[#fed7d7]">
                                Remove from Wishlist
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
