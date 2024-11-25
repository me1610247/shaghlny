@extends('layout')
<title>Applicants On Your Job - Shaghlny Platform</title>

@section('content')
<div class="container mx-auto py-16 px-6">
    <!-- Title Section -->
    <div class="text-center mb-10">
        <h2 class="text-5xl font-extrabold text-[#1a202c]">{{ $job->title }} Position - Applicants</h2>
        <p class="text-lg text-gray-500 mt-4">See the details of all applicants who applied for this job.</p>
    </div>

    @if($applicants->isEmpty())
        <!-- No Applicants Section -->
        <div class="text-center py-10">
            <p class="text-2xl font-medium text-gray-600">No applicants have applied for this job yet.</p>
            <p class="text-lg text-gray-500 mt-2">Check back later as new applicants might appear soon!</p>
        </div>
    @else
        <!-- Applicants Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($applicants as $applicant)
                @php
                    $profile = $applicant->profile; // Assuming $applicant is a User model instance with a Profile relation
                @endphp
                <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="mb-4">
                        <!-- Applicant Name -->
                        <h3 class="text-2xl font-bold text-[#333]">{{ ucwords($applicant->name) }}</h3>
                    </div>
                    <div class="text-gray-600">
                        <!-- Applicant Details -->
                        <p class="text-lg"><strong>Email:</strong> {{ $applicant->email }}</p>
                        <p class="text-lg mt-2"><strong>Phone:</strong> {{ $profile->phone ?? 'Not Provided' }}</p>
                        @if(!empty($profile->skills))
                            <p class="text-lg mt-2"><strong>Skills:</strong></p>
                            <ul class="list-disc pl-6 text-gray-500">
                                @foreach($profile->skills as $skill)
                                    <li>{{ $skill }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-lg mt-2 text-gray-500"><em>No skills listed</em></p>
                        @endif
                    </div>
                    
                    <!-- Contact Button -->
                    <div class="mt-6">
                        <a href="mailto:{{ $applicant->email }}" class="block text-center bg-[#4CAF50] text-white font-semibold py-2 px-4 rounded-lg hover:bg-[#3E8E41] transition-colors duration-300">
                            Contact Applicant
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
