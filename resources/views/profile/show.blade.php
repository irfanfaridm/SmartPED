@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Success Messages -->
        @if (session('status') === 'profile-updated')
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow">
                <div class="bg-green-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                    <div class="text-xs font-bold">{{ now()->format('M') }}</div>
                    <div class="text-sm font-bold">{{ now()->format('d') }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'/>
                    </svg>
                    <span>Profile updated successfully!</span>
                </div>
            </div>
        @endif

        @if (session('status') === 'avatar-removed')
            <div class="mb-6 flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg shadow">
                <div class="bg-blue-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                    <div class="text-xs font-bold">{{ now()->format('M') }}</div>
                    <div class="text-sm font-bold">{{ now()->format('d') }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor' class='w-5 h-5'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'/>
                    </svg>
                    <span>Profile picture removed successfully!</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Profile</h1>
                <a href="{{ route('profile.edit') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Cover Photo -->
            <div class="h-48 bg-gradient-to-r from-red-600 to-red-400 relative">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            </div>

            <!-- Profile Info -->
            <div class="relative px-6 pb-6">
                <!-- Avatar -->
                <div class="flex justify-center -mt-16 mb-4">
                    <div class="relative">
                        @if($user->avatar && Storage::disk('public')->exists($user->avatar))
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center" style="display: none;">
                                <span class="text-white text-3xl font-bold">{{ $user->initials }}</span>
                            </div>
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center">
                                <span class="text-white text-3xl font-bold">{{ $user->initials }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                    <p class="text-gray-600 mb-1">{{ $user->position ?? 'Position not set' }}</p>
                    <p class="text-gray-500 text-sm">{{ $user->department ?? 'Department not set' }}</p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Contact Information</h3>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                        </div>

                        @if($user->phone)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="text-gray-900">{{ $user->phone }}</p>
                            </div>
                        </div>
                        @endif

                        @if($user->address)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="text-gray-900">{{ $user->address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Personal Information</h3>
                        
                        @if($user->date_of_birth)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="text-gray-900">{{ $user->date_of_birth->format('d F Y') }} ({{ $user->age }} years old)</p>
                            </div>
                        </div>
                        @endif

                        @if($user->gender)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Gender</p>
                                <p class="text-gray-900 capitalize">{{ $user->gender }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="text-gray-900">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                @if($user->bio)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">About</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $user->bio }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 