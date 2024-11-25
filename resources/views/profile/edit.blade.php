@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 my-8">
    <h2 class="text-3xl font-bold text-blue-600 mb-6 border-b-2 border-blue-500 pb-2">
        Edit Profile
    </h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold">Name</label>
                <input type="text" name="name" id="name" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('name', Auth::user()->name) }}" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" id="email" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-gray-700 font-semibold">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('phone', $profile->phone) }}">
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="date_of_birth" class="block text-gray-700 font-semibold">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="{{ old('date_of_birth', $profile->date_of_birth) }}">
            </div>
        </div>

        <!-- Skills Section -->
        <div class="mt-6">
            <label for="skills" class="block text-gray-700 font-semibold">Skills</label>
            <div class="relative">
                <input type="text" id="skillInput" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type a skill and press Enter">
                <div id="autocompleteList" class="absolute bg-white border rounded-lg shadow-lg mt-1 hidden"></div>
            </div>
            <div id="skillsContainer" class="mt-4 flex flex-wrap gap-2">
                @if (!empty($profile->skills))
                    @foreach ($profile->skills as $skill)
                        <div class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
                            {{ $skill }}
                            <input type="hidden" name="skills[]" value="{{ $skill }}">
                            <button type="button" class="ml-2 text-red-400 hover:text-red-600 remove-skill">✕</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <small class="text-gray-500">Add skills by typing and pressing Enter. Suggested skills will appear as you type.</small>
        </div>

        <!-- Submit Button -->
        <div class="mt-8 text-right">
            <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    const skillInput = document.getElementById('skillInput');
    const autocompleteList = document.getElementById('autocompleteList');
    const skillsContainer = document.getElementById('skillsContainer');

    const suggestedSkills = ['PHP', 'Laravel','Git','Github','Postman','Bootstrap','Liveiwre','JavaScript', 'HTML', 'CSS', 'React', 'Node.js', 'Python', 'Django', 'SQL', 'Java', 'C++']; // Replace with dynamic suggestions if needed

    // Handle typing and showing suggestions
    skillInput.addEventListener('input', () => {
        const input = skillInput.value.toLowerCase();
        autocompleteList.innerHTML = '';
        if (input) {
            const matches = suggestedSkills.filter(skill => skill.toLowerCase().includes(input));
            matches.forEach(match => {
                const item = document.createElement('div');
                item.textContent = match;
                item.className = 'cursor-pointer px-3 py-2 hover:bg-blue-100';
                item.addEventListener('click', () => {
                    addSkill(match);
                    skillInput.value = '';
                    autocompleteList.innerHTML = '';
                    autocompleteList.classList.add('hidden');
                });
                autocompleteList.appendChild(item);
            });
            autocompleteList.classList.remove('hidden');
        } else {
            autocompleteList.classList.add('hidden');
        }
    });

    // Handle Enter key for adding a skill
    skillInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && skillInput.value.trim()) {
            e.preventDefault();
            addSkill(skillInput.value.trim());
            skillInput.value = '';
            autocompleteList.classList.add('hidden');
        }
    });

    // Add a skill box
    // Add a skill box
function addSkill(skill) {
    const existingSkills = Array.from(document.getElementsByName('skills[]')).map(input => input.value.toLowerCase());
    
    if (existingSkills.includes(skill.toLowerCase())) {
        alert('This skill is already added.');
        return;
    }

    const skillBox = document.createElement('div');
    skillBox.className = 'bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center gap-2';
    skillBox.innerHTML = `
        ${skill}
        <input type="hidden" name="skills[]" value="${skill}">
        <button type="button" class="ml-2 text-red-400 hover:text-red-600 remove-skill">✕</button>
    `;
    skillsContainer.appendChild(skillBox);

    // Add remove functionality
    skillBox.querySelector('.remove-skill').addEventListener('click', () => {
        skillBox.remove();
    });
}


    // Handle removing a skill
    skillsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-skill')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
