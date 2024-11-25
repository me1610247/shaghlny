@extends('layout')

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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($item['icon'] == 'home')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 01-2 2h-4v4a2 2 0 01-2 2h-4a2 2 0 01-2-2v-4H5a2 2 0 01-2-2V9z" />
                        @elseif($item['icon'] == 'plus-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        @elseif($item['icon'] == 'magnifying-glass')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17l-4-4m0 0l-4-4m4 4l4-4m-4 4V7" />
                        @endif
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Main Content (Right) -->
    <div class="md:w-3/4 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Questions for "{{ $job->title }}"</h2>

        <form action="{{ route('jobs.questions.store', $job->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Dynamic Question Fields -->
            <div id="questions-container" class="space-y-4">
                <div class="flex items-center space-x-4">
                    <input type="text" name="questions[]" placeholder="Enter a question"
                           class="w-full p-3 border border-gray-300 rounded-md" required>
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md add-question">+</button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md shadow-md hover:bg-blue-700 transition duration-300">
                Save Questions
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('questions-container');

        document.querySelector('.add-question').addEventListener('click', function() {
            const newField = document.createElement('div');
            newField.className = 'flex items-center space-x-4 mt-4';
            newField.innerHTML = `
                <input type="text" name="questions[]" placeholder="Enter a question" 
                       class="w-full p-3 border border-gray-300 rounded-md" required>
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md remove-question">-</button>
            `;
            container.appendChild(newField);
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('div').remove();
            }
        });
    });
</script>
@endsection
